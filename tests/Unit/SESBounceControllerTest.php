<?php


namespace Megaverse\LaravelSesManager\Tests\Unit;


use Illuminate\Http\Request;
use Mockery\Mock;
use Megaverse\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Megaverse\LaravelSesManager\Controllers\SESWebhookController;
use Megaverse\LaravelSesManager\SESConfirmWebhookMiddleware;
use Megaverse\LaravelSesManager\SESMessageValidator;
use Megaverse\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Megaverse\LaravelSesManager\Tests\TestCase;

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
