<?php

namespace App\Http\Repositories;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Models\Address;
use App\Models\Event;
use App\Models\EventBankDetails;
use App\Models\EventLocation;
use App\Models\EventPeriod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator
    {
        return Event::paginate($request->query('per_page'));
    }

    public function store(StoreEventRequest $request): Event
    {
        $event = new Event();
        $event->user_id = Auth::user()->id;

        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->subscription_deadline = $request->get('subscription_deadline');
        $event->payment_deadline = $request->get('payment_deadline');
        $event->estimated_value = $request->get('estimated_value') ?? 0;

        $file = Str::random(32).'.png';

        $base64_image = $request->get('banner')['data'];
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);

        Storage::put($file, base64_decode($file_data));

        $event->banner_url = $file;
        $event->save();
        $event->refresh();

        $requestEventPeriods = $request->get('event_periods');
        foreach ($requestEventPeriods as $requestEventPeriod) {
            $eventPeriod = new EventPeriod();
            $eventPeriod->event_id = $event->id;

            $eventPeriod->date = $requestEventPeriod['date'];
            $eventPeriod->opening_time = $requestEventPeriod['opening_time'];
            $eventPeriod->closing_time = $requestEventPeriod['closing_time'];
            $eventPeriod->save();
        }

        $eventLocationAddress = $request->get('location')['address'];

        $address = new Address();
        $address->state = $eventLocationAddress['state'];
        $address->city = $eventLocationAddress['city'];
        $address->neighborhood = $eventLocationAddress['neighborhood'];
        $address->zip_code = preg_replace('/\D/', '', $eventLocationAddress['zip_code']);
        $address->street = $eventLocationAddress['street'];
        $address->number = $eventLocationAddress['number'];
        $address->complement = $eventLocationAddress['complement'];
        $address->save();
        $address->refresh();

        $eventLocation = new EventLocation();
        $eventLocation->event_id = $event->id;
        $eventLocation->address_id = $address->id;
        $eventLocation->maps_link = $request->get('location')['maps_link'];
        $eventLocation->save();

        $requestBankDetails = $request->get('bank_details');
        $eventBankDetails = new EventBankDetails();
        $eventBankDetails->event_id = $event->id;
        $eventBankDetails->bank = $requestBankDetails['bank'];
        $eventBankDetails->holder = $requestBankDetails['holder'];
        $eventBankDetails->pix_key = $requestBankDetails['pix_key'];
        $eventBankDetails->save();

        return $event->refresh();
    }

    public function find(string $eventId): Event
    {
        return Event::find($eventId);
    }

    public function findOrFail(string $eventId): Event
    {
        return Event::findOrFail($eventId);
    }

    public function update(string $eventId, UpdateEventRequest $request)
    {
        $event = $this->findOrFail($eventId);

        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->subscription_deadline = $request->get('subscription_deadline');
        $event->payment_deadline = $request->get('payment_deadline');
        $event->estimated_value = $request->get('estimated_value') ?? 0;
        if ($request->has('banner.data')) {
            Storage::delete($event->banner_url);
            $file = Str::random(32).'.png';

            $base64_image = $request->get('banner')['data'];
            @list($type, $file_data) = explode(';', $base64_image);
            @list(, $file_data) = explode(',', $file_data);

            Storage::put($file, base64_decode($file_data));
        }
        $event->save();

        // Exclui os que foram removidos
        $requestEventPeriods = $request->get('event_periods');
        foreach ($event->event_periods as $eventPeriod) {
            $found = false;
            foreach ($requestEventPeriods as $requestEventPeriod) {
                if (($eventPeriod->date == $requestEventPeriod['date']) &&
                ($eventPeriod->opening_time == $requestEventPeriod['opening_time'] &&
                ($eventPeriod->closing_time == $requestEventPeriod['closing_time']))) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $eventPeriod->delete();
            }
        }

        // Adiciona os novos
        $event->refresh();
        foreach ($requestEventPeriods as $requestEventPeriod) {
            $found = false;
            foreach ($event->event_periods as $eventPeriod) {
                if (($eventPeriod->date == $requestEventPeriod['date']) &&
                ($eventPeriod->opening_time == $requestEventPeriod['opening_time'] &&
                ($eventPeriod->closing_time == $requestEventPeriod['closing_time']))) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $newEventPeriod = new EventPeriod();
                $newEventPeriod->event_id = $event->id;

                $newEventPeriod->date = $requestEventPeriod['date'];
                $newEventPeriod->opening_time = $requestEventPeriod['opening_time'];
                $newEventPeriod->closing_time = $requestEventPeriod['closing_time'];

                $newEventPeriod->save();
            }
        }

        $eventLocationAddress = $request->get('location')['address'];

        $event->location->address->state = $eventLocationAddress['state'];
        $event->location->address->city = $eventLocationAddress['city'];
        $event->location->address->neighborhood = $eventLocationAddress['neighborhood'];
        $event->location->address->zip_code = preg_replace('/\D/', '', $eventLocationAddress['zip_code']);
        $event->location->address->street = $eventLocationAddress['street'];
        $event->location->address->number = $eventLocationAddress['number'];
        $event->location->address->complement = $eventLocationAddress['complement'];
        $event->location->address->save();

        $event->location->maps_link = $request->get('location')['maps_link'];
        $event->location->save();

        $requestBankDetails = $request->get('bank_details');
        $event->bank_details->bank = $requestBankDetails['bank'];
        $event->bank_details->holder = $requestBankDetails['holder'];
        $event->bank_details->pix_key = $requestBankDetails['pix_key'];
        $event->bank_details->save();

        return $event->refresh();
    }

    public function cancel(string $eventId, CancelEventRequest $request)
    {
        $event = $this->findOrFail($eventId);

        // TODO: Cancelar evento

        return $event;
    }

    public function indexParticipants(string $eventId, Request $request)
    {
        return $this->findOrFail($eventId)->participants()->paginate($request->query('per_page'));
    }

    public function addParticipant(string $eventId, StoreEventParticipantDTO $dto)
    {
        $event = $this->findOrFail($eventId);

        // TODO: Adicionar participante ao evento

        return $event;
    }

    public function indexOrganizers(string $eventId, Request $request)
    {
        // TODO: Listar organizadores do evento
    }

    public function addOrganizer(string $eventId, User $user)
    {
        // TODO: Adicionar organizador ao evento
    }

    public function removeOrganizer(string $eventId, string $organizerId)
    {
        // TODO: Remover organizador do evento
    }

    // TODO: Registrar chegada do participante ao evento (leitura do QR Code)
}
