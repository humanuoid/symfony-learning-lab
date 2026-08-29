# Codebase Map

The macro layout: the top-level areas and what each holds. A map to navigate, not the full tree.

```mermaid
flowchart TD
    root[project root]
    root --> config[config/]
    root --> src[src/]
    root --> templates[templates/]
    root --> public[public/]
    root --> migrations[migrations/]
    root --> tests[tests/]
    root --> docker[.docker/]
    root --> aidd_docs[aidd_docs/]
```

## Areas

- `config/`: Symfony configuration files and routes
- `src/`: PHP source code, entry point is Kernel.php
- `templates/`: Twig templates
- `public/`: Web root, entry point is index.php
- `migrations/`: Doctrine database migrations
- `tests/`: Test files and bootstrap
- `.docker/`: Docker configuration for FrankenPHP
- `aidd_docs/`: AI project documentation and memory

## Entry points

- `public/index.php`: Web entry point
- `bin/console`: CLI entry point