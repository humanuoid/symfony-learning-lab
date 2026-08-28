# Deployment

How this project is built and shipped.

## Local Development

- Docker Compose for service containers (PostgreSQL, Mailpit, FrankenPHP)
- Compose files: compose.yaml (base), compose.override.yaml (overrides)
- Services exposed:
  - PostgreSQL: port 5432
  - Mailpit: ports 1025 (SMTP), 8025 (web)
  - FrankenPHP: ports 80 (HTTP), 443 (HTTPS), 443/udp (HTTP/3)

## Production

- No production deployment configured yet
- Symfony Flex for dependency management
- Composer for PHP dependencies

## Build process

- `composer install` for dependencies
- `composer dump-autoload` for autoloading
- Doctrine migrations for database schema
- `docker compose build` for FrankenPHP image

## Environment

- Development: .env and .env.dev
- Test: .env.test
- Production: .env (not committed)
