<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Invitado;
use App\Models\User;

class InvitadoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invitado $invitado): bool
    {
        return $invitado->evento->usuario_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invitado $invitado): bool
    {
        return $invitado->evento->usuario_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invitado $invitado): bool
    {
        return $invitado->evento->usuario_id === $user->id;
    }
}
