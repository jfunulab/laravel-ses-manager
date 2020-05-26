<?php


namespace Megaverse\LaravelSesManager;

use Illuminate\Http\Request;
use Megaverse\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Megaverse\LaravelSesManager\Exceptions\WrongWebhookRouting;
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
      if (
          !$request->hasHeader('X-Amz-Sns-Topic-Arn')  &&
          (config('ses-manager.sns.bounce_topic_arn') !== $request->header('X-Amz-Sns-Topic-Arn') ||
              config('ses-manager.sns.complaint_topic_arn') !== $request->header('X-Amz-Sns-Topic-Arn'))
      ) {
          return new Response('Bad Request', 400);
      }

      if ($this->messageValidatorContract->payload->notificationType == 'SubscriptionConfirmation') {
          $this->messageValidatorContract->confirmSubscription($this->messageValidatorContract->payload->message);
          return new Response('confirmed', 200);
      }

      return $next($request);
  }
}
