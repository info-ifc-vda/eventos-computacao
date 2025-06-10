<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventBankDetails;
use App\Models\EventLocation;
use App\Models\EventOrganizer;
use App\Models\EventPeriod;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventsSeeder extends Seeder
{
    public function run()
    {
        // find user with email
        $user = User::where('email', 'event_creator@gmail.com')->first();
        if (!$user) {
            $this->command->error('Nenhum usuário encontrado. Certifique-se de que o seeder de usuários foi executado antes deste.');
            return;
        }

        $file = Str::random(32).'.png';

        Storage::put($file, file_get_contents(resource_path('img/banner.png')));

        $event = Event::create([
            'user_id' => $user->id,
            'title' => 'Evento de Teste',
            'description' => 'Este é um evento de teste criado pelo seeder.',
            'subscription_deadline' => now()->addDays(7),
            'payment_deadline' => now()->addDays(14),
            'banner_url' => $file,
            'estimated_value' => 100.00,
            'cancellation_date' => null,
            'cancellation_description' => null,
        ]);

        $eventLocationAddress = Address::create([
            'state' => 'SC',
            'city' => 'Videira',
            'neighborhood' => 'Campo Experimental',
            'zip_code' => '89564590',
            'street' => 'Rodovia SC 135',
            'number' => 'km 125',
            'complement' => null,
        ])->refresh();

        $eventLocation = EventLocation::create([
            'event_id' => $event->id,
            'address_id' => $eventLocationAddress->id,
            'maps_link' => 'https://maps.app.goo.gl/ppXQssbxpxVwrXns7'
        ]);

        $eventOrganizer = EventOrganizer::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $eventBankDetails = EventBankDetails::create([
            'event_id' => $event->id,
            'bank' => 'Sicoob',
            'holder' => 'IFC Videira',
            'pix_key' => '49123456789'
        ]);

        $eventPeriod = EventPeriod::create([
            'event_id' => $event->id,
            'date' => now()->addDays(8),
            'opening_time' => '09:00:00',
            'closing_time' => '17:00:00'
        ]);
    }
}
