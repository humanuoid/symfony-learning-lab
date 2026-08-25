# Auth

The project's authentication and authorization setup.

## Stack

- Symfony SecurityBundle
- Symfony Security component
- Configurable authentication providers

## Current state

- SecurityBundle installed and configured
- No authentication implementation yet
- Ready for various auth methods:
  - Form login
  - API token
  - OAuth
  - JWT

## Configuration

- Security configuration in config/packages/security.yaml
- Firewall configuration for different URL patterns
- Access control rules for secured areas
