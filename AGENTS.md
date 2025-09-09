# AGENTS.md

## Run Commands

- Frontend build: `npm run build` (uses Vite)
- Development server: `npm run dev` (runs Vite and `php artisan serve`)

## Code Style Guidelines

- PHP: Follow PSR-12 standards. Use strict types (`declare(strict_types=1);`). Imports: Group use statements (classes, functions, constants). Naming: CamelCase for classes, snake_case for variables/methods. Error handling: Use try-catch with specific exceptions; log via Laravel's Log facade.
- JS: ES modules (import/export). Use const/let over var. Naming: camelCase for variables/functions. Formatting: 2-space indentation. Follow Airbnb style if adding ESLint.
- Blade templates: Consistent indentation, use @if/@foreach. Avoid inline scripts; use Alpine.js for interactivity.
- General: No trailing whitespace. Unix line endings (LF). Imports: Alphabetize and group (external, internal). No magic numbers; use constants. Security: Validate/sanitize inputs with Laravel validators.

## Additional Notes

- Project is Laravel-based with modular structure (Modules/). Use Laravel conventions for models, controllers, migrations.
- For modules, follow nwidart/laravel-modules patterns: Service providers, routes in module dirs.

## From iydheko (user)

- using midtrans as the only payment
- laravel project
- i always speak the feature in indonesian, so you can check it in @lang/id.json, the origin is english in @lang/en.json
