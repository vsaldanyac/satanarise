# Agent Architecture Guide (PHP)

## Purpose

This document is the canonical architecture guide for AI agents working in a PHP repository.

Use it to decide:

1. where a new file belongs,
2. how modules should be structured,
3. how the main runtime flows are organized,
4. what contracts and boundaries should not be changed by mistake.

For concrete verification paths, recommended commands, smoke/debug workflows, and test selection by risk, use the project's PHP verification guide.

Use that document when:

- you need to decide which tests to run for a change,
- you need the recommended command for a verification task,
- you need to inspect controller, queue, or API behavior,
- you are debugging a regression and want the cheapest reliable verification path.

## Project layout (source of truth)

Application code lives under `src/` and is autoloaded through PSR-4.

- `Http/`: HTTP layer (controllers, requests, responses, middleware)
- `Services/`: application use cases and orchestration
- `Domain/`: pure domain transformations and business rules
- `Repositories/`: app-level persistence and query operations
- `Integrations/`: low-level SDK and provider adapters
- `Core/`: shared cross-cutting concerns (config, errors, logging)
- `Support/`: utility helpers with no business orchestration

Operational scripts and developer utilities live under `scripts/` when the project uses them.

Test code lives under `tests/`.

Test layout guidance:

- `Unit/`: pure logic, fast tests, fakes or mocks allowed
- `Integration/`: repository, service, and API integration with controlled dependencies
- `Feature/` or `E2E/`: real routing and user-visible behavior validation

## Main flows and starting points

Use these paths to orient quickly in the current runtime:

- HTTP request flow: start with `Http/` controllers, request objects, and the primary application service; main flow is request validation -> service orchestration -> domain transformation -> response serialization
- async or queued flow: start with the job, command handler, or queue consumer plus the related service; main flow is payload validation -> orchestration -> domain work -> persistence or event publication
- persistence-backed workflows: start with `Repositories/`, the service entrypoint, and the adapter code in `Integrations/`

## Layer responsibilities

### `Http/`

Contains transport concerns only:

- request and response objects,
- endpoint wiring,
- middleware composition,
- calling a service method,
- translating typed application errors into HTTP responses.

Do not place business logic in controllers.

### `Services/`

Contains use-case orchestration:

- coordinates repository and integration calls,
- validates use-case inputs,
- maps domain outputs to response shape.

Use semantic service APIs such as `AnswerService::answer(...)`.

### `Domain/`

Contains pure logic:

- parsers and normalizers,
- transformation logic,
- deterministic rules,
- value objects and domain-specific policies.

Keep domain code independent from HTTP, framework controllers, and SDK clients.

### `Repositories/`

Contains storage operations with application meaning:

- retrieve aggregates for a use case,
- fetch records by business key,
- delete and upsert domain-relevant records.

Repository methods should express business intent, not raw query builder or SQL details.

### `Integrations/`

Contains low-level external clients:

- provider initialization,
- auth and config wiring,
- direct SDK setup,
- raw client request execution.

Do not place app-level query semantics here.

## File placement rules (decision guide)

When adding code, decide by intent:

1. New endpoint -> `Http/`
2. New use case -> `Services/<BoundedContext>/`
3. New pure transformation or rule -> `Domain/<Subdomain>/`
4. New app-level persistence or query behavior -> `Repositories/`
5. New external provider adapter or client -> `Integrations/<ProviderOrKind>/`
6. New reusable helper (non-domain, non-use-case) -> `Support/`

If a module needs both SDK setup and business-aware queries, split it:

- SDK setup in `Integrations/`
- business-aware operations in `Repositories/`

## Naming conventions

- Class names: `PascalCase` (`AnswerService`, `ParsingService`)
- Methods: `camelCase`
- Namespaces: `PascalCase` segments under the project root namespace
- Files: one class per file with matching class name
- Error codes: uppercase with underscores (`PARSE_DOCUMENT_FAILED`)

Use semantic names that describe behavior:

- prefer `answer(...)` over `doQuery(...)`
- prefer `browse(...)` over generic `run(...)` when behavior is specific

## API and output contracts

Preserve existing response contracts unless the task explicitly requires changes.

Examples:

- JSON response shapes must keep keys expected by callers
- event or stream responses must keep semantics expected by clients

Breaking these contracts requires explicit task scope.

## Error handling rules

Use typed application errors from `Core/Errors` or the project equivalent:

- `ValidationError` for invalid input,
- `DomainError` for domain-level invalid data or rule failures,
- `UseCaseError` for use-case failures,
- `InfrastructureError` for provider or storage failures,
- `ExternalServiceError` for external dependency failures when the distinction matters.

HTTP transport mapping should be centralized in the transport layer.

Avoid leaking raw framework, ORM, or SDK exceptions across layer boundaries.

## Configuration and runtime environment

- PHP version must be defined by the project dependency configuration
- Dependency management should be centralized in Composer
- Runtime configuration should be centralized in a dedicated config layer
- Prefer existing settings and environment wiring over new ad-hoc constants
- Install, setup, and verification commands should live in a dedicated verification guide

## Testing guidance

- Unit tests should cover pure domain logic and deterministic transformations
- Integration tests should cover repository, service, and controller interaction
- Feature or end-to-end tests should cover real routing and user-visible flows
- Use the cheapest verification path that can detect the risk introduced by the change

## Anti-patterns (do not introduce)

- business logic inside controllers
- app-specific query semantics inside `Integrations`
- raw framework exceptions returned directly to upper layers
- duplicate implementations of the same responsibility across layers
- creating new compatibility wrappers unless the task explicitly asks for them