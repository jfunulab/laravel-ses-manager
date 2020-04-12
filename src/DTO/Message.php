<?php


namespace Jfunu\LaravelSesManager\DTO;


class Message
{
    /**
     * @var array
     */
    public $message;

    public $notificationType;

    public function __construct(array $data)
    {
        $this->notificationType = $data['notificationType'] ?? $data['Type'];

        $this->message = ($this->notificationType == 'SubscriptionConfirmation') ? $data : $data[strtolower($this->notificationType)];
    }

}