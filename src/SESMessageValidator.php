<?php


namespace Jfunu\LaravelSesManager;


use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed;

class SESMessageValidator implements SESMessageValidatorContract
{
    public $payload;

    public function __construct()
    {
        $this->payload = $this->getPayload();
    }

    public function getMessage()
    {
        return $this->payload->message;
    }

    /**
     * @param array $message
     * @throws SesConfirmationFailed
     */
    public function confirmSubscription(array $message)
    {
        $url = $message['SubscribeURL'];
        $handle = curl_init($message['SubscribeURL']);
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($handle);

        curl_close($handle);
        info($output);

        if (!curl_errno($handle)) {
            throw new SesConfirmationFailed();
        }
    }


    public function getPayload()
    {
        $rawRequestBody = file_get_contents('php://input');

        $data = json_decode($rawRequestBody, true);

        if (JSON_ERROR_NONE !== json_last_error() || !is_array($data)) {
            throw new \RuntimeException('Invalid POST data.');
        }

        return new \Jfunu\LaravelSesManager\Message($data);
    }

}
