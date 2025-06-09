<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

describe('POST /api/v1/events/{event_id}/participants/arrival', function () {
    it('registra chegada com sucesso para organizador e participante do evento', function () {
        $organizer = User::factory()->create();
        $participant = User::factory()->create();
        $event = Event::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $organizer->id,
            'title' => 'Evento Teste',
            'description' => 'Desc',
            'subscription_deadline' => now()->addDays(5),
            'payment_deadline' => now()->addDays(10),
            'banner_url' => 'https://fakeimg.pl/600x400',
            'estimated_value' => 100,
        ]);
        // Vincula organizador
        \DB::table('event_organizers')->insert([
            'event_id' => $event->id,
            'user_id' => $organizer->id,
        ]);
        // Participante faz parte do evento
        $eventParticipant = EventParticipant::create([
            'user_id' => $participant->id,
            'event_id' => $event->id,
        ]);
        // Permissão de organizador
        $organizer->permissions()->create(['permission' => 'organizer']);

        $response = $this->actingAs($organizer)
            ->postJson("/api/v1/events/{$event->uuid}/participants/arrival", [
                'participant_id' => $participant->id,
            ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'uuid', 'name', 'email', 'arrival_date',
        ]);
        $this->assertNotNull($response->json('arrival_date'));
        $eventParticipant->refresh();
        $this->assertNotNull($eventParticipant->arrival_date);
    });

    it('retorna erro 400 se participante não pertence ao evento', function () {
        $organizer = User::factory()->create();
        $participant = User::factory()->create();
        $event = Event::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $organizer->id,
            'title' => 'Evento Teste',
            'description' => 'Desc',
            'subscription_deadline' => now()->addDays(5),
            'payment_deadline' => now()->addDays(10),
            'banner_url' => 'https://fakeimg.pl/600x400',
            'estimated_value' => 100,
        ]);
        // Vincula organizador
        \DB::table('event_organizers')->insert([
            'event_id' => $event->id,
            'user_id' => $organizer->id,
        ]);
        // Permissão de organizador
        $organizer->permissions()->create(['permission' => 'organizer']);

        $response = $this->actingAs($organizer)
            ->postJson("/api/v1/events/{$event->uuid}/participants/arrival", [
                'participant_id' => $participant->id,
            ]);

        $response->assertStatus(400);
        $response->assertSee('Participante não faz parte do evento');
    });

    it('retorna erro 401 se usuário não autenticado', function () {
        $event = Event::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => 1,
            'title' => 'Evento Teste',
            'description' => 'Desc',
            'subscription_deadline' => now()->addDays(5),
            'payment_deadline' => now()->addDays(10),
            'banner_url' => 'https://fakeimg.pl/600x400',
            'estimated_value' => 100,
        ]);
        $response = $this->postJson("/api/v1/events/{$event->uuid}/participants/arrival", [
            'participant_id' => 999,
        ]);
        $response->assertStatus(401);
    });

    it('retorna erro 403 se usuário autenticado não for organizador', function () {
        $user = User::factory()->create();
        $participant = User::factory()->create();
        $event = Event::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'title' => 'Evento Teste',
            'description' => 'Desc',
            'subscription_deadline' => now()->addDays(5),
            'payment_deadline' => now()->addDays(10),
            'banner_url' => 'https://fakeimg.pl/600x400',
            'estimated_value' => 100,
        ]);
        // Não vincula como organizador nem permissão
        $response = $this->actingAs($user)
            ->postJson("/api/v1/events/{$event->uuid}/participants/arrival", [
                'participant_id' => $participant->id,
            ]);
        $response->assertStatus(403);
    });
});
