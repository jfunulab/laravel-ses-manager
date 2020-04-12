<?php


namespace Jfunu\LaravelSesManager;

use Illuminate\Http\Request;
use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Symfony\Component\HttpFoundation\Response;

class SESConfirmWebhookMiddleware
{
  /**
   * @var SESMessageValidatorContract
   */
  private $messageValidatorContract;

  public function __construct(SESMessageValidatorContract $messageValidatorContract)
  {
    $this->messageValidatorContract = $messageValidatorContract;
  }

  /**
   * @param Request $request
   * @param $next
   * @return string
   * @throws Exceptions\SesConfirmationFailed
   */
  function handle (Request $request, $next) {

      if ($this->messageValidatorContract->payload->notificationType == 'SubscriptionConfirmation') {
          $this->messageValidatorContract->confirmSubscription($this->messageValidatorContract->payload->message);
          return new Response('confirmed', 200);
      }

      return $next($request);
  }
}
