<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (string) $user->id === (string) $id;
});

Broadcast::channel('notify_admin', function () {
    return true;
});

Broadcast::channel('notify.{id}', function ($user, $id) {
    return (string) $user->id === (string) $id;
});


