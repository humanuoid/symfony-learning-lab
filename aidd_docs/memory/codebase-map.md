# Codebase Map

The top-level areas and what each owns. One line per directory, the role it plays.

| Area | Owns |
| ---- | ---- |
| `config/` | Symfony configuration (routes, services, bundles) |
| `src/` | Application code (Kernel, Controllers, Entities, Repositories) |
| `src/Kernel.php` | Symfony application kernel |
| `src/Controller/` | HTTP controllers (currently empty) |
| `src/Entity/` | Doctrine entities (currently empty) |
| `src/Repository/` | Doctrine repositories (currently empty) |
| `templates/` | Twig templates |
| `public/` | Web entry point (index.php) |
| `migrations/` | Doctrine database migrations |
| `assets/` | Static assets |
| `translations/` | Translation files |
| `tests/` | PHPUnit/Pest test files |
| `bin/` | Console entry point |
| `compose.yaml` | Docker Compose configuration for PostgreSQL |
| `compose.override.yaml` | Docker Compose overrides for Mailpit |
| `var/` | Cache and logs (generated) |
| `vendor/` | Composer dependencies (generated) |
