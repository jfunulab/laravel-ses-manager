<?php


namespace Jfunu\LaravelSesManager\Controllers;

use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Jfunu\LaravelSesManager\Jobs\HandleSESBounce;
use Jfunu\LaravelSesManager\Jobs\HandleSESComplaint;
use Jfunu\LaravelSesManager\SESConfirmWebhookMiddleware;
use Jfunu\LaravelSesManager\SESMessageValidator;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SESWebhookController extends Controller
{
  use DispatchesJobs;
  
  /**
   * @var SESMessageValidator
   */
  private $SESMessageValidator;

  public function __construct(SESMessageValidatorContract $SESMessageValidator)
  {
    $this->SESMessageValidator = $SESMessageValidator;
    $this->middleware(SESConfirmWebhookMiddleware::class);
  }

  /**
   * @return string
   * @throws WrongWebhookRouting
   * @throws \Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed
   */
  public function bounce() {
    $message = $this->getMessageOfType('Bounce');

    $this->dispatchNow(new HandleSESBounce($message));

    return new Response('handled', 200);
  }

  /**
   * @throws WrongWebhookRouting
   */
  public function complaint() {
    $message = $this->getMessageOfType('Complaint');

    $this->dispatchNow(new HandleSESComplaint(
      $message
    ));

    return new Response('handled', 200);
  }

  /**
   * @param string $string
   * @return mixed
   * @throws WrongWebhookRouting
   */
  private function getMessageOfType(string $string)
  {
    return $this->SESMessageValidator->getMessageOfType($string);
  }
}
