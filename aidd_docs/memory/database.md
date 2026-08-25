# Database

The project's data persistence layer and schema.

## Stack

- Doctrine ORM 3.6+
- DoctrineBundle 3.3+
- Doctrine Migrations Bundle 4.0+
- PostgreSQL 16 (via Docker Compose)

## Schema

- No entities defined yet (empty src/Entity/)
- No migrations created yet (empty migrations/ except version files)
- Schema will be managed through Doctrine migrations

## Configuration

- Connection details in .env (DATABASE_URL)
- Local PostgreSQL via Docker Compose (compose.yaml)
- Migrations configured in config/packages/doctrine_migrations.yaml

## Access

- Doctrine repositories for database access
- QueryBuilder for complex queries
- DQL for direct queries when needed
