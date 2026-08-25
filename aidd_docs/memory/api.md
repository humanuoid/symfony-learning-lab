# API

The project's HTTP API endpoints and conventions.

## Stack

- Symfony HTTP component
- Symfony FrameworkBundle
- Symfony Routing component
- Symfony Serializer for JSON handling

## Current state

- No API endpoints defined yet
- Empty src/Controller/ directory
- Routes configured via annotations or YAML

## Conventions

- RESTful API design
- JSON request/response format
- API routes under /api/ prefix (convention)
- Resource controllers for CRUD operations

## Response format

- Success: 200 OK with JSON body
- Created: 201 Created with Location header
- Errors: 4xx/5xx with JSON error details
