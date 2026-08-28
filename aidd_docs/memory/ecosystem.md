# Ecosystem

The external services and tools this project uses and does not build itself.

## Services

| Service | Purpose | Config | Access |
|---------|---------|--------|--------|
| GitHub | Version control and CI/CD | .git/config | Human: web, Agent: cli |
| PostgreSQL | Database | compose.yaml | Human: web, Agent: cli |
| Mailpit | Email testing | compose.override.yaml | Human: web, Agent: cli |
| FrankenPHP | PHP application server with Caddy | .docker/frankenphp/Dockerfile, compose.yaml | Human: web, Agent: cli |

## Development Tools

| Tool | Purpose | Config | Access |
|------|---------|--------|--------|
| PHPStan | Static analysis | composer.json | Human: cli, Agent: cli |
| Pest | Testing framework | composer.json | Human: cli, Agent: cli |
| PHP CodeSniffer | Code style checking | composer.json | Human: cli, Agent: cli |
| Rector | Automated refactoring | composer.json | Human: cli, Agent: cli |
| XDebug | Debugging | .docker/frankenphp/Dockerfile | Human: cli, Agent: cli |

## Hand-offs

- GitHub triggers Docker Compose for local development
- Symfony Messenger uses Doctrine transport for message queuing
- FrankenPHP serves the Symfony application with Caddy as the web server
