<?php


namespace Jfunu\LaravelSesManager\Tests\Unit;


use Illuminate\Http\Request;
use Mockery\Mock;
use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Jfunu\LaravelSesManager\Controllers\SESWebhookController;
use Jfunu\LaravelSesManager\SESConfirmWebhookMiddleware;
use Jfunu\LaravelSesManager\SESMessageValidator;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Jfunu\LaravelSesManager\Tests\TestCase;

class SESBounceControllerTest extends TestCase
{
  public function testComplainFailOnWrongMessage() {
    /**
     * @var SESMessageValidatorContract|Mock $failingValidator
     */
    $failingValidator = \Mockery::mock(
      SESMessageValidator::class
    );

    $failingValidator->shouldReceive('getMessageOfType')
      ->andThrow(new WrongWebhookRouting('ses', 'confirm', []));
    $this->expectException(WrongWebhookRouting::class);

    (new SESWebhookController($failingValidator))->complaint();
  }
  
  public function testBounceFailOnWrongMessage() {
    /**
     * @var SESMessageValidatorContract|Mock $failingValidator
     */
    $failingValidator = \Mockery::mock(
      SESMessageValidator::class
    );

    $failingValidator->shouldReceive('getMessageOfType')
      ->andThrow(new WrongWebhookRouting('ses', 'confirm', []));
    $this->expectException(WrongWebhookRouting::class);

    (new SESWebhookController($failingValidator))->bounce();
  }
}
