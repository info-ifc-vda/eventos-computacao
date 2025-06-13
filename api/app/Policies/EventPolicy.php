<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    /**
     * Verifica se o usuário é organizador do evento.
     */
    public function organizer(User $user, Event $event): bool
    {
        // Considera que existe relação many-to-many entre eventos e organizadores
        return $event->organizers()->where('users.id', $user->id)->exists();
    }
} 