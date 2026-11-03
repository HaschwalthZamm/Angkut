<?php

namespace App\Services\Notification\Contracts;

use App\Models\User;

interface Notifier
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function send(User $user, array $payload): void;
}
