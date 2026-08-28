# VCS

Version control setup and conventions for this project.

## Platform

- GitHub: https://github.com/humanuoid/symfony-learning-lab
- Current branch: chore/tools

## Conventions

### Branches
- **Main branch**: `main`
- **Feature branches**: Use **kebab-case** and prefix with type:
  - `feat/` for new features (e.g., `feat/user-registration`)
  - `fix/` for bug fixes (e.g., `fix/order-validation`)
  - `refactor/` for code refactoring (e.g., `refactor/service-layer`)
  - `docs/` for documentation changes (e.g., `docs/update-architecture`)
  - `chore/` for maintenance tasks (e.g., `chore/update-dependencies`)
  - `test/` for test-related changes (e.g., `test/add-user-tests`)

### Commit Messages
Follow **Conventional Commits** (https://www.conventionalcommits.org/) with these rules:

#### Format
```
<type>(<scope>): <subject>

<body>

<footer>
```

#### Types
| Type | Usage | Example |
|------|-------|---------|
| `feat` | New feature | `feat(user): add registration use case` |
| `fix` | Bug fix | `fix(order): validate stock before checkout` |
| `docs` | Documentation changes | `docs(memory): add Clean Architecture guidelines` |
| `refactor` | Code refactoring (no functional changes) | `refactor(user): extract domain layer` |
| `chore` | Maintenance tasks | `chore: update dependencies` |
| `test` | Test-related changes | `test(user): add registration tests` |
| `style` | Code style changes (formatting, etc.) | `style: apply PSR-12 fixes` |
| `perf` | Performance improvements | `perf(query): optimize user lookup` |
| `build` | Build system or dependency changes | `build: update PHPStan config` |
| `ci` | CI/CD changes | `ci: add GitHub Actions workflow` |

#### Scope
- **Optional** but recommended for clarity.
- Use **kebab-case** and keep it short.
- Examples: `memory`, `user`, `order`, `src`, `config`, `infrastructure`

#### Subject
- **Imperative mood** (e.g., "add" not "added", "fix" not "fixed").
- **Start with a verb** (e.g., "update", "add", "remove", "fix").
- **Lowercase** and **no period** at the end.
- **Max 50 characters** (for readability in `git log --oneline`).

#### Body
- **Explain WHY**, not WHAT (the code shows what).
- **Use simple English** (easy for French developers with intermediate level).
- **Wrap at 72 characters** (standard for Git).
- **Separate from subject with a blank line**.

#### Footer
- **Reference issues** (e.g., `Closes #123`).
- **Breaking changes** (e.g., `BREAKING CHANGE: ...`).

### Examples

#### Good Commit Messages
```
feat(user): add registration use case

Add UserRegistrationService to handle user sign-up flow.
This separates business logic from HTTP concerns.

Closes #42
```

```
fix(order): validate stock before checkout

Prevent orders with insufficient stock from being placed.
This fixes the bug reported in #56.
```

```
docs(memory): update project architecture guidelines

Add Clean Architecture + Hexagonal + DDD guidelines.
Remove CQRS references to simplify the architecture.
```

```
refactor(user): extract domain layer

Move User entity and Value Objects to Domain/User/.
This aligns with Clean Architecture principles.
```

#### Bad Commit Messages
```
❌ "fixed bug" (no type, no scope, no context)
❌ "Added user registration" (past tense, no type)
❌ "WIP: user stuff" (vague, not actionable)
❌ "fix: User registration not working" (no scope, no body)
```

### Additional Rules
- **Atomic commits**: One logical change per commit.
- **No giant commits**: If a commit has >500 lines, split it.
- **Squash trivial commits**: Use `git rebase -i` to squash "WIP" or "fix typo" commits.
- **Sign commits**: Use `git commit -S` for signed commits (optional).

## Workflow

1. **Create feature branch from main**
   ```bash
   git checkout main
   git pull origin main
   git checkout -b feat/my-feature
   ```

2. **Commit changes with clear, atomic messages**
   ```bash
   git add src/Domain/User/Entity/User.php
   git commit -m "feat(user): add User entity with validation"
   ```

3. **Open PR for review**
   - Use the PR template (if available).
   - Link to the issue (if any).
   - Request review from at least 1 team member.

4. **Address feedback**
   - Fix issues in new commits (do not amend pushed commits).
   - Use `git commit --fixup <hash>` for small fixes.

5. **Merge with squash or rebase**
   - Prefer **squash** for feature branches with many small commits.
   - Prefer **rebase** for long-lived branches (e.g., `main`).

## Git hooks

- None configured currently

## Tools

### Commit Message Validation
Use [Commitizen](https://commitizen.github.io/cz-cli/) or [commitlint](https://commitlint.js.org/) to enforce Conventional Commits:

```bash
# Install commitlint
npm install --save-dev @commitlint/cli @commitlint/config-conventional

# Add to package.json
{
  "commitlint": {
    "extends": ["@commitlint/config-conventional"]
  }
}

# Add Git hook (optional)
npx husky add .husky/commit-msg 'npx --no -- commitlint --edit $1'
```

### Git Aliases
Add these aliases to your `~/.gitconfig` for easier workflow:

```ini
[alias]
    co = checkout
    br = branch
    ci = commit
    st = status
    lg = log --oneline --graph --all
    lga = log --oneline --graph --all --decorate
```

## Best Practices

1. **Write meaningful messages**: A good commit message helps others (and future you) understand the change.
2. **Keep commits small**: Easier to review and revert if needed.
3. **Use branches wisely**: Short-lived branches for features, long-lived for `main`/`develop`.
4. **Rebase often**: Keep your branch up-to-date with `main` to avoid merge conflicts.
5. **Test before committing**: Run tests and linters before committing.

## References

- [Conventional Commits](https://www.conventionalcommits.org/)
- [Git Best Practices](https://git-scm.com/book/en/v2/Distributed-Git-Contributing-to-a-Project)
- [Symfony Contributing Guide](https://symfony.com/doc/current/contributing/code/index.html)
