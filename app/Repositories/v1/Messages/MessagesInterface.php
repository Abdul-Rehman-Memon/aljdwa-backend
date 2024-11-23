<?php

namespace App\Repositories\v1\Messages;

interface MessagesInterface
{
    public function createMessage(array $data);
    public function getMessage(string $senderId);
    public function markMessageAsRead(string $senderId);
}
