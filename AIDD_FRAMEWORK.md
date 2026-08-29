# AIDD Framework Guide

This project uses the [AIDD framework](https://github.com/ai-driven-dev/framework) to structure AI-driven development workflows.

## Core Concepts

### Agents vs Skills

- **Agents**: Specialized AI sub-agents invoked with `@` prefix. They operate as autonomous workers that execute specific development tasks.
- **Skills**: Specialized workflows invoked with `/` prefix. They provide guided, step-by-step assistance for specific development activities.

## Agents

Agents are invoked with `@` prefix and operate as autonomous executors.

### Available Agents
- **`@aidd-dev-checker`**: Judges finished work against its validator and the real need, leaving nothing unchecked. Use for independent verification before shipping.
- **`@aidd-dev-executor`**: Turns a dispatched task into working, validated code that fits the project. Use when an approved scope must become code.

## Skills

Skills are invoked with `/` prefix and provide guided workflows for specific tasks.

### Planning & Architecture
- **`/aidd-dev-01-plan`**: Turn requests or tickets into phased implementation plans
- **`/aidd-pm-02-user-stories`**: Slice epics into ordered user stories
- **`/aidd-pm-03-prd`**: Generate Product Requirements Documents

### Development
- **`/aidd-dev-02-implement`**: Write code phase by phase from existing plans
- **`/aidd-dev-06-test`**: Write and iterate tests until they pass
- **`/aidd-dev-07-refactor`**: Improve code across cleanup, performance, security, architecture
- **`/aidd-dev-08-debug`**: Reproduce and fix bugs through hypothesis validation

### Review & Validation
- **`/aidd-dev-03-assert`**: Validate implementations against coding assertions
- **`/aidd-dev-04-audit`**: Audit codebase across seven quality pillars
- **`/aidd-dev-05-review`**: Review diffs before shipping

### Project Context
- **`/aidd-context-02-project-memory`**: Build and refresh project memory
- **`/aidd-context-11-explore`**: Explore codebase structure and available skills

## Usage Guidelines

### When to Use Agents

| Task | Recommended Agent |
|------|------------------|
| Independent verification | `@aidd-dev-checker` |
| Code implementation from plan | `@aidd-dev-executor` |

### When to Use Skills

| Task | Recommended Skill |
|------|------------------|
| Starting a new feature | `/aidd-dev-01-plan` then `/aidd-dev-02-implement` |
| Writing tests | `/aidd-dev-06-test` |
| Debugging | `/aidd-dev-08-debug` |
| Code review | `/aidd-dev-05-review` |
| Refactoring | `/aidd-dev-07-refactor` |
| Project setup | `/aidd-context-02-project-memory` |

## Project-Specific Skills

Custom skills for this Symfony project are located in `.agents/skills/` following [OpenCode nomenclature](https://opencode.ai/docs/skills/).

For the full AIDD playbook, see: [framework docs](https://github.com/ai-driven-dev/framework)
