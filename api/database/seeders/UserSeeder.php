<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Artisan;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        //* Usuario com permissao admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'email_verified_at' => new DateTime(),
            'password' => Hash::make('Yametekudas@1'),
        ]);

        UserPermission::create([
            'user_id' => $admin->id,
            'permission' => 'admin',
        ]);

        //* Usuario com permissao event_creator
        $event_creator = User::create([
            'name' => 'Event Creator',
            'email' => 'event_creator@gmail.com',
            'email_verified_at' => new DateTime(),
            'password' => Hash::make('Yametekudas@1'),
        ]);

        UserPermission::create([
            'user_id' => $event_creator->id,
            'permission' => 'event_creator',
        ]);
        //* Criar usuário common_user
        $common_user = User::create([
            'name' => 'Common User',
            'email' => 'common_user@gmail.com',
            'email_verified_at' => new DateTime(),
            'password' => Hash::make('Yametekudas@1'),
        ]);

        Artisan::call('passport:client --password -q');
    }
}
