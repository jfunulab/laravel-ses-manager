<?php


namespace Megaverse\LaravelSesManager\Tests\Unit;


use Illuminate\Http\Request;
use Mockery\Mock;
use Megaverse\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Megaverse\LaravelSesManager\SESConfirmWebhookMiddleware;
use Megaverse\LaravelSesManager\SESMessageValidator;
use Megaverse\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Megaverse\LaravelSesManager\Tests\TestCase;

class HandleSESWebhookMiddlewareTest extends TestCase
{
  /**
   * @throws \Megaverse\LaravelSesManager\Exceptions\SesConfirmationFailed
   */
  public function testConfirmReturnFalseForFailingValidator() {
    /**
     * @var SESMessageValidatorContract|Mock $failingValidator
     */
    $failingValidator = \Mockery::mock(
      SESMessageValidator::class
    );
    $failingValidator->shouldReceive('getConfirmationMessage')
      ->andReturns();


    $request = \Mockery::mock(Request::class);

    $str = 'should be reached';
    $next = function ($request) use ($str) {
      return $str;
    };

    $this->assertEquals(
      $str,
      (new SESConfirmWebhookMiddleware($failingValidator))->handle(
        $request,
        $next
      )
    );
  }

  /**
   * @throws \Megaverse\LaravelSesManager\Exceptions\SesConfirmationFailed
   */
  public function testConfirmReturnTrue() {
    /**
     * @var SESMessageValidatorContract|Mock $validator
     */
    $validator = \Mockery::mock(
      SESMessageValidator::class
    );
    $validator->shouldReceive('getConfirmationMessage')
      ->andReturns(['ok']);

    $validator->shouldReceive('confirmSubscription')
      ->andReturns();

    $request = \Mockery::mock(Request::class);
    $str = 'should not be reached';
    $next = function ($request) use ($str) {
      return $str;
    };
    $this->assertNotEquals(
      $str,
      (new SESConfirmWebhookMiddleware($validator))->handle(
        $request,
        $next
      )
    );
  }
}
