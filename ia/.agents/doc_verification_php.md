# Agent Verification Guide (PHP)

## Purpose

Use this document to choose the right verification path for a task without rediscovering scripts, services, or test suites.

This is not a catalog of every command in the repository.
It is a curated guide for:

- fast local checks,
- integration validation,
- end-to-end validation,
- debugging API and queue behavior.

Use the cheapest verification that can detect the risk introduced by the task.

## Verification Strategy

Prefer this order:

1. unit tests for local contract or rule changes,
2. integration tests for multi-layer or repository or API behavior,
3. feature or end-to-end tests for real routing, real infrastructure, or final user-visible behavior,
4. manual smoke or debug commands only when tests are too indirect or when you need to inspect live payloads.

Do not default to feature or E2E for every change.
Do use them when HTTP wiring, queue behavior, persistence integration, or final response contracts are the real success criterion.

## Quick Map

### I changed pure logic or parsing

Use:

- `php artisan test --testsuite=Unit`

Best for:

- JSON parsing,
- normalization rules,
- mapping logic,
- DTO transformation rules,
- response contract helpers.

### I changed service wiring, repositories, or API contracts

Use:

- `php artisan test --testsuite=Feature`

Best for:

- API response shape,
- repository and service interaction,
- framework container wiring,
- error handler behavior,
- external adapter wiring.

### I changed final routing, queues, or user-visible behavior

Use:

- `php artisan test`

Best for:

- controller to service to repository flow,
- queue-backed workflows,
- final response contract validation,
- user-visible behavior across boundaries.

## Recommended Commands By Goal

### Verify full unit safety net

```bash
php artisan test --testsuite=Unit
```

Use when:

- touching domain rules,
- changing parsing logic,
- refactoring services internally.

If the project is not Laravel, use the repository's canonical PHPUnit or Pest unit command instead.

### Verify API + repository integration

```bash
php artisan test --testsuite=Feature
```

Use when:

- changing route behavior,
- changing repository contracts,
- changing database wiring,
- changing integration fixtures.

If the project is not Laravel, use the repository's canonical integration or feature test command instead.

### Verify end-to-end behavior

```bash
php artisan test
```

Use when:

- changing final response behavior,
- changing queue or event semantics,
- changing real infrastructure-backed workflows,
- validating user-visible behavior before handoff.

Notes:

- use isolated test data,
- ensure external resources are cleaned up,
- avoid shared mutable environments.

### Run a single targeted test file

```bash
./vendor/bin/phpunit tests/Unit/AnswerServiceTest.php
```

Use when:

- the change is narrow,
- you need fast feedback before broader verification.

If the project uses Pest, use the repository's canonical Pest command instead.

## Manual / Debug Checks

### Smoke test an HTTP endpoint against a running API

```bash
curl -s -X POST "http://127.0.0.1:8000/query" \
  -H "Content-Type: application/json" \
  -d '{"question":"What is the objective of FIRST?"}'
```

Use when:

- the API is already running,
- you want a quick HTTP contract check.

Warning:

- prefer automated feature or integration tests for canonical verification,
- use manual calls for fast confirmation or debugging.

### Inspect queue or event behavior directly

Use the framework's queue worker, logs, or event inspection tooling against a local environment.

Best for:

- checking dispatched jobs,
- verifying final job outcomes,
- reproducing integration bugs without using the frontend.

### Run the application locally for manual verification

```bash
php artisan serve
```

Use when:

- the project uses Laravel,
- you need a local runtime for endpoint inspection.

If the project uses Symfony or a custom runtime, use the repository's canonical run command instead.

## Database and External Dependency Verification Notes

### Relational database tests

For tests that require a real database:

- use isolated test databases or containers,
- avoid shared development databases,
- clean up records created during the test run.

### Queues, caches, and third-party APIs

For tests that require real infrastructure:

- isolate queue names, cache keys, or topic names,
- record enough evidence to diagnose failures,
- remove test artifacts before finishing.

## Validation Selection Rules

- unit tests are required for pure logic changes,
- integration or feature tests are required when service, repository, or API boundaries change,
- broader end-to-end validation is required when user-visible behavior or real infrastructure behavior changes,
- manual smoke checks do not replace automated verification.

## Failure Handling

When a validation fails:

1. identify the failing layer,
2. fix the issue at the correct boundary,
3. rerun the failed validation,
4. rerun any narrower prerequisite checks needed to confirm the fix,
5. report the exact command that passed.