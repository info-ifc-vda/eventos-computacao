<?php

namespace App\Http\Repositories;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Models\Address;
use App\Http\Requests\StoreEventExpenseRequest;
use App\Models\Event;
use App\Models\EventBankDetails;
use App\Models\EventLocation;
use App\Models\EventPeriod;
use App\Models\User;
use App\Models\EventExpense;
use App\Models\EventExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        return Event::where('uuid', $eventId)->firstOrFail();
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

        $requestEventPeriods = $request->get('event_periods');
        foreach ($event->event_periods as $eventPeriod)
        {

        }
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
        $eventLocation->maps_link = 'sem uso';
        $eventLocation->save();

        $requestBankDetails = $request->get('bank_details');
        $eventBankDetails = new EventBankDetails();
        $eventBankDetails->event_id = $event->id;
        $eventBankDetails->bank = $requestBankDetails['bank'];
        $eventBankDetails->holder = $requestBankDetails['holder'];
        $eventBankDetails->pix_key = $requestBankDetails['pix_key'];
        $eventBankDetails->save();

        return $event->refresh();

        return $event;
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

    public function getAllExpenses(int $internalEventId, Request $request): LengthAwarePaginator
    {
        return EventExpense::fromEvent($internalEventId)->paginate($request->query('per_page'));
    }

    public function storeExpense(int $internalEventId, StoreEventExpenseRequest $request): EventExpense
    {
        $eventExpense = new EventExpense();
        $eventExpense->event_id = $internalEventId;
        $eventExpense->user_id = Auth::user()->id;
        $eventExpense->proof_access_key = $request->get('proof_access_key');
        $eventExpense->items_total = $request->get('items_total');
        $eventExpense->title = $request->get('title');
        $eventExpense->save();
        // $eventExpense->refresh();

        // $requestEventExpenseItems = $request->get('items');
        // foreach ($requestEventExpenseItems as $requestEventExpenseItem)
        // {
        //     $eventExpenseItem = new EventExpenseItem();
        //     $eventExpenseItem->event_expense_id = $eventExpense->id;
        //     $eventExpenseItem->description = $requestEventExpenseItem['description'];
        //     $eventExpenseItem->unit_value = $requestEventExpenseItem['unit_value'];
        //     $eventExpenseItem->quantity = $requestEventExpenseItem['quantity'];
        //     $eventExpenseItem->discount = 0;
        //     $eventExpenseItem->total_value = $eventExpenseItem->unit_value * $eventExpenseItem->quantity;
        //     $eventExpenseItem->save();
        // }
        // $eventExpense->refresh();
        // $eventExpense->items_total = $eventExpense->items()->sum('total_value');
        // $eventExpense->save();

        return $eventExpense->refresh();
    }

    public function findEventExpenseOrFail(int $internalEventId, string $eventExpenseId): EventExpense
    {
        return EventExpense::fromEvent($internalEventId)->where('uuid', $eventExpenseId)->with('items')->firstOrFail();
    }

    // // Métodos para despesas
    // public function getEventExpenses(string $eventId, int $perPage = 15): LengthAwarePaginator
    // {
    //     return EventExpense::where('event_id', $eventId)
    //         ->with(['user', 'items'])
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($perPage);
    // }

    // public function createEventExpense(string $eventId, array $data): EventExpense
    // {
    //     return DB::transaction(function () use ($eventId, $data) {
    //         // Criar a despesa
    //         $expense = EventExpense::create([
    //             'event_id' => $eventId,
    //             'user_id' => Auth::user()->id,
    //             'proof_access_key' => $data['proof_access_key'],
    //             'items_total' => 0, // Será calculado após criar os itens
    //         ]);

    //         // Criar os itens da despesa
    //         $totalValue = 0;
    //         foreach ($data['items'] as $itemData) {
    //             $discount = $itemData['discount'] ?? 0;
    //             $itemTotal = ($itemData['unit_value'] * $itemData['quantity']) - $discount;

    //             EventExpenseItem::create([
    //                 'event_expense_id' => $expense->id,
    //                 'description' => $itemData['description'],
    //                 'unit_value' => $itemData['unit_value'],
    //                 'quantity' => $itemData['quantity'],
    //                 'discount' => $discount,
    //                 'total_value' => $itemTotal,
    //             ]);

    //             $totalValue += $itemTotal;
    //         }

    //         // Atualizar o valor total da despesa
    //         $expense->update(['items_total' => $totalValue]);

    //         // Carregar os relacionamentos para retorno
    //         return $expense->load('items');
    //     });
    // }

    // public function findEventExpense(string $eventId, string $expenseId): ?EventExpense
    // {
    //     return EventExpense::where('event_id', $eventId)
    //         ->where('uuid', $expenseId)
    //         ->with(['user', 'items'])
    //         ->first();
    // }

    // public function getUserEventExpenses(string $eventId, string $userId): Collection
    // {
    //     return EventExpense::where('event_id', $eventId)
    //         ->where('user_id', $userId)
    //         ->with('items')
    //         ->get();
    // }

    // TODO: Registrar chegada do participante ao evento (leitura do QR Code)
}
