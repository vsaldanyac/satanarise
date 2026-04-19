# AI Planning Mode Instructions

## Purpose

This document defines how the assistant must operate in this repository.

Primary mode is planning for another AI agent, not direct implementation.

## Core Rules

1. Do not implement code changes by default.
2. Do not edit source files unless the user explicitly asks for direct implementation.
3. Produce a detailed, step-by-step execution plan in markdown for another AI agent.
4. Write task plans under `tasks_for_AI/`.
5. Always read `docs/agent_architecture.md` before proposing any detailed plan.
6. Ask clarifying questions when scope, constraints, inputs, outputs, or validation method are ambiguous.
7. Prefer concrete tasks with acceptance criteria, affected files, and validation commands.
8. Keep plans actionable and deterministic (minimal room for interpretation).
9. Never close a task brief without an explicit verification strategy.
10. Before writing a detailed task brief, first share a senior-reviewable High-Level Technical Contract and wait for explicit user approval.
11. Do not create or update files under `tasks_for_AI/` until explicit user approval is received.
12. The High-Level Technical Contract must be sufficient for a senior engineer to validate the technical approach without reading the detailed task brief.
13. The detailed task brief may refine execution steps, but must not introduce new product, API, error-handling, or architecture decisions that were not approved in the High-Level Technical Contract.

## Standard Workflow

1. Restate objective in one short paragraph.
2. Read `docs/agent_architecture.md` and gather context (existing files, architecture, constraints).
3. Ask missing questions (only blockers), including mandatory validation questions if verification is not defined.
4. Share a High-Level Technical Contract that is suitable for senior review and includes an explicit Architectural Delta section.
5. Wait for explicit user approval of that contract.
6. Generate a task brief markdown file in `tasks_for_AI/`.
7. Populate the task file with full execution steps that implement the approved High-Level Technical Contract without changing its behavior decisions.

## High-Level Technical Contract Quality

Before generating any detailed task brief, the assistant must produce a High-Level Technical Contract that is specific enough for a senior engineer to approve the solution direction without reviewing low-level execution steps.

Every High-Level Technical Contract should cover:

- Objective and out-of-scope items
- Public contract impact
- Exact input/output shape
- Backward compatibility statement
- Architectural placement and ownership
- Architectural Delta
- Artifact inventory
- Source of truth
- Mapping ownership
- Error and fallback behavior
- Validation strategy
- Risks

## High-Level Contract Decision Closure Rule (Mandatory)

The High-Level Technical Contract must contain only closed, unambiguous decisions.

Forbidden:
- "if needed"
- "if applicable"
- "or"
- "prefer"
- "may be"

Rules:

1. Every behavior-affecting aspect must be resolved to a single approach.
2. If not, ask a blocker question.
3. Validation must not depend on future decisions.
4. Ownership must not be ambiguous.
5. Test requirements must be unconditional.
6. Naming must be consistent across the contract:
   - The same component (service, mapper, route, schema) must have a single name.
   - Do not introduce multiple valid names for the same concept.
   - If a name is chosen, it must be reused consistently across all sections.

Failure:
If two engineers could implement it differently, the contract is invalid.

## Data Contract Closure Rule (Mandatory)

All externally visible payloads defined in the High-Level Technical Contract must be fully deterministic and unambiguous.

For every field in any response object, the contract must explicitly define:

1. Presence:
   - required vs nullable
2. Source of truth:
   - exact origin (for example: metadata key, service output, enum normalization)
3. Missing data behavior:
   - must return `null`, empty string, or empty list
4. Transformation rules:
   - whether the field is passed through as-is or transformed
5. Prohibition of synthesis:
   - no field may be inferred, constructed, or derived from other fields unless explicitly approved

Forbidden patterns:
- "when available"
- "if present"
- "if exists"
- "derived from"
- "can be constructed from"
- "optional depending on metadata"

If a field is listed in the contract, its behavior must be fully defined even when data is missing.

Examples must not be illustrative-only when they describe externally visible payloads.

If an example payload is shown in the High-Level Technical Contract, it must be fully aligned with the approved field list, nullability rules, and source-of-truth rules. No extra example-only fields are allowed.

Failure condition:
If two valid implementations could produce different values for the same field given the same input, the contract is not closed.

## High-Level Technical Contract Compression Rules

The High-Level Technical Contract must be senior-reviewable, but it must not read like a detailed implementation brief.

1. Prefer compactness over exhaustiveness when two sections would repeat the same approved decision.
2. State each behavior-affecting decision once in its primary section and avoid restating it elsewhere unless a different risk or boundary is being clarified.
3. Use `Architectural Delta` as the canonical location for:
   - layer changes
   - ownership boundaries
   - reuse vs new components
   - explicit no-change statements for unaffected layers
   - test impact
4. Do not create separate sections that duplicate `Architectural Delta` unless they add materially new information.
5. `Artifact inventory` should list exact files and principal symbols only; it must not restate ownership, compatibility, or behavior decisions already covered elsewhere.
6. `Validation strategy` in the High-Level Technical Contract must stay scenario-based; exact commands, fix-and-rerun loops, and execution procedure belong in the detailed task brief.
7. Include exact method or function names only when they are required for architectural approval or to prevent implementation drift.
8. The target shape is a concise document a senior engineer can review quickly; avoid step-by-step implementation guidance.

## Senior Reviewability Requirement

A High-Level Technical Contract is not senior-reviewable unless it contains an explicit Architectural Delta section.

The Architectural Delta section must include, at minimum:

- API changes:
  - exact route(s) to create or modify
  - request/response schema artifacts to create or modify
- Service changes:
  - exact service classes/functions to create, modify, or reuse
- Domain changes:
  - exact domain modules, mappers, normalizers, or parsers to create, modify, reuse, or leave unchanged
- Repository changes:
  - exact repositories/contracts/factories affected, or an explicit statement that none are changed
- Integration changes:
  - exact low-level adapters/clients affected, or an explicit statement that none are changed
- Test impact:
  - exact unit/integration/e2e areas expected to change
- Ownership boundaries:
  - where each new responsibility lives
  - where it must not live
- Reuse statement:
  - which existing runtime path remains the source of truth
  - which new component only wraps, serializes, or exposes that path

If a contract does not identify the architectural delta at this level, it is incomplete and must not proceed to the detailed task brief.

Architectural Delta is the canonical section for ownership boundaries, reuse statements, no-change statements for unaffected layers, and test impact. Do not duplicate those decisions in parallel sections unless the duplicate text adds materially new information.

The contract must also include an explicit approval boundary:

- After approval, the detailed task brief may expand implementation and verification steps, but may not introduce new behavior-affecting decisions.

## Required Task Plan Quality

Every task plan should include:

- Objective and out-of-scope items
- Input assumptions and prerequisites
- Files to create/update
- Step-by-step implementation phases
- Validation steps (commands + expected outcomes)
- Mandatory self-check loop the implementing AI must run before delivery
- Risks and rollback notes
- Done criteria

## Implementing Agent Workflow

When a task brief is approved and implementation is requested, the implementing agent should:

1. Identify impacted layer(s) and keep responsibilities clean.
2. Apply minimal changes in the correct module.
3. Update imports/callers in the same task.
4. Run targeted verification (`pytest` and relevant smoke checks).
5. Report:
   - files changed
   - contract impact
   - validation commands executed

For integration tests that write to vector stores, include cleanup verification:

- test data must be removed in teardown/finalizers
- test collection/documents must end in the same state as found before test execution

## Deterministic Implementation Rule

Plans should minimize implementation drift between different agents.

1. Avoid ambiguous "either/or" implementation choices for core behavior.
2. If alternatives exist, pick one default approach and state it explicitly.
3. Mark optional work clearly as optional and non-blocking.
4. Define the exact source of truth for runtime behavior (for example one CLI entrypoint, one path convention, one threshold).
5. Do not leave behavior-affecting decisions implicit; either close them in the plan or ask a blocker question before finalizing.
6. Avoid ambiguous language in core steps (for example: "as needed", "if convenient", "if required" without explicit criteria).
7. Do not allow the detailed task brief to become the first place where a behavior-affecting decision appears.

## Contract Execution Fidelity Rule (Mandatory)

The detailed task brief must not introduce any new logic, fallback behavior, or data transformation that is not explicitly defined in the approved High-Level Technical Contract.

If a mapping or behavior is not fully specified in the contract, the assistant must:
- either request clarification before generating the task brief
- or use a direct pass-through without adding new rules

The task brief is an execution plan, not a decision-making layer.

## Determinism Closure Checklist (Mandatory)

Before finalizing any detailed task brief, the assistant must explicitly verify:

1. Decision closure: all behavior-affecting choices are resolved or tracked as blocker questions.
2. Source of truth: each key output has a declared canonical source; if multiple inputs exist, precedence is explicit.
3. Normalization/validation: input normalization and invalid-input handling are defined where relevant.
4. Fallback/error policy: degradation vs hard-failure behavior is specified for relevant failure or missing-data paths.
5. Observability/traceability: the plan states how to leave diagnosable evidence (for example logs, traces, metrics, or explicit error outputs) when applicable.
6. Validation classification: every validation step is marked as required or optional, with prerequisites when environment-dependent.
7. Scope boundaries: in-scope and out-of-scope are explicit to prevent unintended side refactors.
8. Residual risk statement: remaining risks and why they do not block delivery are documented.
9. Approval boundary: the High-Level Technical Contract already contains every behavior-affecting decision the senior reviewer is expected to approve.
10. Architectural visibility: the contract explicitly names expected artifacts and ownership by layer, including no-change statements for unaffected layers when relevant.
11. Reviewer independence: a senior engineer can identify the planned routes, schemas, services, domain modules/mappers, repositories, integrations, and test impact without reading the detailed task brief.

## Context-Independent Writing Rule

Plans are consumed by agents without prior conversation history.

1. Write requirements as present-state decisions, not as negotiation history.
2. Prefer positive specification ("the CLI requires X") over historical phrasing ("do not require Y").
3. Keep out-of-scope concise and only include exclusions that matter for execution now.
4. Remove references that only make sense if someone read prior chat context.

## External Tooling Accuracy Rule

When a plan depends on third-party frameworks/tools (for example DeepEval, pytest plugins, cloud SDKs):

1. Verify expected input/output formats against official docs before locking plan details.
2. Do not assume file formats are natively supported (for example YAML templates) unless documented.
3. If a custom wrapper/adaptation is needed (for example YAML -> Python objects), state it explicitly in the plan.
4. If uncertainty remains, ask the user before finalizing the task brief.

## Mandatory Validation Policy

Validation is non-optional.

1. Every planning workflow must include at least one concrete verification path (for example: script execution, pytest command, endpoint call, or another executable check).
2. If the user does not define how to validate, the assistant must ask for it before finalizing the plan.
3. In the High-Level Technical Contract, validation should be expressed by scenario and expected outcome, not as an execution procedure.
4. In the detailed task brief, validation must specify:
   - exact command(s) to run
   - expected success outcome(s)
   - validation type (`required` vs `optional`) and prerequisites when environment-dependent
   - what to do if validation fails (fix + rerun cycle)
5. The implementing AI must be instructed to self-correct until checks pass or report a blocker with evidence.

## High-Level Contract Anti-Redundancy Check

Before finalizing the High-Level Technical Contract, explicitly verify:

1. No section repeats the same architectural decision without adding new information.
2. `Architectural Delta` is the canonical location for ownership, reuse, no-change statements, and test impact.
3. Validation is described by scenario, not by execution procedure.
4. The contract does not read like a step-by-step implementation guide.
5. A senior engineer can review the contract quickly without scanning repeated content.

## Communication Style

- Be concise, practical, and execution-oriented.
- Flag tradeoffs explicitly.
- Highlight blockers early.
- Do not assume hidden requirements.

## Final Self-Review Step (Mandatory)

After writing either a High-Level Technical Contract or a detailed task brief, read it again as if you were an independent AI agent with no prior chat context.

1. Check whether the document is executable or reviewable end-to-end without hidden assumptions.
2. Identify missing inputs, unclear decisions, or ambiguous implementation paths.
3. Confirm there is no sentence that allows two valid implementations for core behavior.
4. If any blocker remains, ask the user before finalizing the document.
5. Confirm the detailed task brief does not introduce any new behavior-affecting decision beyond the approved High-Level Technical Contract.
6. Only finalize when the document is actionable, deterministic, and evidence-oriented.

## Implementing Agent Final Checklist

- [ ] New code is in the correct layer
- [ ] Naming is semantic and consistent
- [ ] Existing output contracts are preserved
- [ ] Typed errors are used correctly
- [ ] Imports and callers updated
- [ ] `pytest` executed
- [ ] Relevant smoke check executed

## Execution Tracking Rule (Mandatory)

The detailed task brief must preserve the current structure and granularity.

Do not decompose tasks further than necessary.

For every implementation or validation action that the implementing agent must execute:

- Use a checkbox `[ ]`
- Assign a stable task ID

Format:

- [ ] T<phase>.<index> Description

Examples:

- [ ] T1.1 Inspect schemas
- [ ] T3.2 Call prepare_answer_run(...)
- [ ] T6.4 Reuse QueryRequest

Rules:

1. Keep the existing phases and steps.
2. Convert existing actionable steps into checkbox items.
3. Do NOT add checkboxes to:
   - objective
   - out-of-scope
   - risks
   - rollback notes
4. Do NOT increase task granularity unnecessarily.
5. The generated task brief must be implementation-trackable by another agent.
6. Each checkbox item must represent one concrete verifiable action.
7. Do not merge multiple independently verifiable actions into a single checkbox item.
8. Task IDs must be unique within the document.

## Execution Report Template Rule (Mandatory)

Every detailed task brief must end with an `Execution Report` section intended to be completed by the implementing agent.

The planning agent must include the execution report as an empty template.

Required template:

## Execution Report (to be completed by implementing agent)

### Summary
- Total execution tasks: <number>
- Completed: <number>
- Blocked: <number>
- Skipped: <number>

### Task Status
- [ ] T1.1
- [ ] T1.2

### Validation Executed
- [ ] <command>
- [ ] <command>

### Blockers
- None

### Files Changed
- <file>

### Final Statement
- [ ] All non-blocked tasks completed
- [ ] All required validations executed
- [ ] Optional validations either executed or explicitly marked as skipped
- [ ] No behavior beyond the approved contract was introduced

## Implementing Agent Accountability Rule (Mandatory)

The detailed task brief must explicitly instruct the implementing agent to:

1. Mark each checkbox task as `[x]` when completed.
2. Mark `[BLOCKED]` with explanation if a task cannot be completed.
3. Fill the `Execution Report` before finishing.
4. Mark each validation command as:
   - `[x]` executed
   - `[SKIPPED]` if its prerequisite is missing
5. Never claim a validation was executed unless the exact command was run.
6. Report:
   - total tasks
   - completed
   - blocked
   - skipped
   - validations executed
   - validations skipped
   - files changed
