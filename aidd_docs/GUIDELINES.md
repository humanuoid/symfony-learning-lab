# AI Operating Guidelines

How this team drives AI coding assistants on this project. Keep it short and specific to this repo. Fill the placeholders, drop what does not apply.

## House rules

- A failing test comes before any bug fix
- Never edit the generated client under src/api/
- Commits stay atomic and intention-revealing

## Validation depth

- A quick check for small changes, full review for architectural changes
- All tests must be green before a merge

## When the AI drifts

- Reset the session and restate the objective in one sentence

For the general AIDD playbook (planning, review loops, prompting and context hygiene, anti-patterns), see the framework docs: <https://github.com/ai-driven-dev/framework>.
