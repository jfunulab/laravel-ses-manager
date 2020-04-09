# laravel-ses-manager
Logs AWS Simple Email Service bounces and complaints for Laravel app

# Setup
```bash
composer require jfunu/laravel-ses-manager
php artisan migrate
```

- Add the routes to your controller and off you go

```php
// api.php
Route::post('/webhooks/ses/bounce', [Jfunu\LaravelSesManager\Controllers::class, 'bounce']);
Route::post('/webhooks/ses/complaint', [Jfunu\LaravelSesManager\Controllers::class, 'complaint']);
```

- Map the hooks in your SES dashboard to the your application routes.

# Usage
Use `Jfunu\LaravelSesManager\Eloquent\BlackListItem` is the model for blacklisted emails.
```php
// check if email is blacklisted
$blackListItem = Jfunu\LaravelSesManager\Eloquent\BlackListItem::query()
  ->whereNotNull('blacklisted_at')
  ->where('email', $email)
  ->first();

// whitelist email while keeping it in the history
$blackListItem->delete();

// remove email and remove it from the history
$blackListItem->forceDelete();
```
