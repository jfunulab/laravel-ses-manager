# laravel-ses-manager
Logs AWS Simple Email Service bounces and complaints for Laravel app

# Setup
```bash
composer require Megaverse/laravel-ses-manager
php artisan migrate
```

- Add the routes to your controller and off you go

```php
// api.php
Route::post('/webhooks/ses/bounce', [Megaverse\LaravelSesManager\Controllers\SESWebhookController::class, 'bounce']);
Route::post('/webhooks/ses/complaint', [Megaverse\LaravelSesManager\Controllers\SESWebhookController::class, 'complaint']);
```

- Map the hooks in your SES dashboard to the your application routes.

# Usage
Use `Megaverse\LaravelSesManager\Eloquent\BlackListItem` is the model for blacklisted emails.
```php
// check if email is blacklisted
$blackListItem = Megaverse\LaravelSesManager\Eloquent\BlackListItem::query()
  ->whereNotNull('blacklisted_at')
  ->where('email', $email)
  ->first();

// whitelist email while keeping it in the history
$blackListItem->delete();

// remove email and remove it from the history
$blackListItem->forceDelete();
```
