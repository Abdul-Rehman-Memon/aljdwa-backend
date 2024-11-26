<?php
namespace App\Services\v1;

use App\Repositories\v1\Messages\MessagesInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class MessageService
{
    protected $messageRepository;

    public function __construct(MessagesInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage(array $data)
    {
        $message = $this->messageRepository->createMessage($data);

        return $message;
    }

    public function getMessage(string $senderId)
    {
        $message = $this->messageRepository->getMessage($senderId);

        return $message;
    }

    public function markMessageAsRead(string $senderId)
    {
        $message = $this->messageRepository->markMessageAsRead($senderId);

        return $message;
    }

    public function getUnreadMessagesCount()
    {
        $message = $this->messageRepository->getUnreadMessagesCount();

        return $message;
    }
}
