<?php


namespace Megaverse\LaravelSesManager\DTO;


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

        $this->message = ($this->notificationType == 'SubscriptionConfirmation') || ($this->notificationType == 'AmazonSnsSubscriptionSucceeded') ? $data : $data[strtolower($this->notificationType)];
    }

}