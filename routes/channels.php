<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('chat.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('send-message',function(){
    // return true;
    return 'Reverb Socket Connected for message channel';
});
