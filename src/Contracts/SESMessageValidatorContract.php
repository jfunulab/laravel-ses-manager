<?php


namespace Jfunu\LaravelSesManager\Contracts;

use Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;

interface SESMessageValidatorContract
{
  /**
   * @return array mixed
   * @throws WrongWebhookRouting
   */
  public function getMessage();

  /**
   * @param array $message
   * @throws SesConfirmationFailed
   */
  public function confirmSubscription(array $message);
}