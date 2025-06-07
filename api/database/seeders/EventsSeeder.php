<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;

class EventsSeeder extends Seeder
{
    public function run()
    {
        // find user with email
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $this->command->error('Nenhum usuário encontrado. Certifique-se de que o seeder de usuários foi executado antes deste.');
            return;
        }

        Event::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'title' => 'Evento de Teste',
            'description' => 'Este é um evento de teste criado pelo seeder.',
            'subscription_deadline' => now()->addDays(7),
            'payment_deadline' => now()->addDays(14),
            'banner_url' => 'https://placehold.co/600x400/orange/white?text=Banner+do+Evento',
            'estimated_value' => 100.00,
            'cancellation_date' => null,
            'cancellation_description' => null,
        ]);

    }
}
