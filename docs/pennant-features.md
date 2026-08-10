# Feature Management with Laravel Pennant

This application uses **Laravel Pennant** to manage the rollout of features like OAuth providers and guestbook functionality. This allows for safe testing in production by hiding features from the general public while keeping them accessible to authorized testers.

## Available Features

The following features are currently defined in `config/pennant.php`:

- `auth-github`: GitHub OAuth login.
- `auth-google`: Google OAuth login.
- `auth-apple`: Apple OAuth login.
- `guestbook-signees`: Displaying "Signee" markers on the guestbook map.

## Toggling Features Globally

You can enable or disable features globally (stored in the database) using the custom Artisan command:

### Enable a feature
```bash
php artisan pennant:toggle auth-github
```

### Disable a feature
```bash
php artisan pennant:toggle auth-github --off
```

**Note:** Disabling a feature via `--off` removes the database override, which means the feature reverts to its default logic (session-based or allow-list-based).

## Preview Mode (Session-based)

You can temporarily enable all features for your current session by appending a secret query parameter to the URL:

```
https://blhamm.com/?preview_mode=YOUR_SECRET_TOKEN
```

The secret token is defined by the `PENNANT_PREVIEW_TOKEN` environment variable. Once visited, the `preview_mode` is stored in your session, and all features will remain active until the session expires or is cleared.

## Email Allow-list

Authenticated users with emails listed in the `PENNANT_ALLOW_LIST` environment variable will always see all features, regardless of their global status or session state.

The list should be comma-separated in your `.env` file:
```env
PENNANT_ALLOW_LIST=brandon@example.com,tester@example.com
```

This supports both standard users and users authenticated via the `signee` guard.

## Implementation Details

- **Middleware:** `App\Http\Middleware\PreviewModeMiddleware` handles the `preview_mode` query parameter.
- **Provider:** `App\Providers\AppServiceProvider::defineFeatures()` contains the resolution logic.
- **Config:** `config/pennant.php` defines the list of valid features.
- **UI:** Blade directives like `@feature('feature-name')` are used in views to conditionally render content.
