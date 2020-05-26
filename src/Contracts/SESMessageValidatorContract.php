<?php


namespace Megaverse\LaravelSesManager\Contracts;

use Megaverse\LaravelSesManager\Exceptions\SesConfirmationFailed;
use Megaverse\LaravelSesManager\Exceptions\WrongWebhookRouting;

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