<?php


namespace Jfunu\LaravelSesManager\Tests\Unit;


use Illuminate\Http\Request;
use Mockery\Mock;
use Jfunu\LaravelSesManager\Contracts\SESMessageValidatorContract;
use Jfunu\LaravelSesManager\SESConfirmWebhookMiddleware;
use Jfunu\LaravelSesManager\SESMessageValidator;
use Jfunu\LaravelSesManager\Exceptions\WrongWebhookRouting;
use Jfunu\LaravelSesManager\Tests\TestCase;

class HandleSESWebhookMiddlewareTest extends TestCase
{
  /**
   * @throws \Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed
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
   * @throws \Jfunu\LaravelSesManager\Exceptions\SesConfirmationFailed
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
