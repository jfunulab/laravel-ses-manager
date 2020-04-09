<?php


namespace Jfunu\LaravelSesManager\Contracts;

use Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;

interface SESMessageValidatorContract
{
  /**
   * @param string $type
   * @return array mixed
   * @throws WrongWebhookRouting
   */
  public function getMessageOfType($type);

  /**
   * @param array $message
   * @throws SesConfirmationFailed
   */
  public function confirmSubscription(array $message);
}