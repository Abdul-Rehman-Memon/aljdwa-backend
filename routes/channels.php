<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (string) $user['id'] === (string) $id;
});


// Broadcast::channel('send-message',function(){
//     // return true;
//     return 'Reverb Socket Connected for message channel';
// });
