---
name: close-requirement
description: Turn a rough task or idea into a decision-closed, senior-reviewable requirement by asking structured questions grounded in the existing codebase. Only draft the final artifact after all key decisions are resolved and the user confirms.
---

# Close Requirement

## Purpose

Help the user transform a vague task or idea into a **decision-closed, technically clear requirement**.

This artifact must be understandable by a senior engineer and serve as input for Spec-Driven Development (SDD) planning.

Do not optimize for wording.  
Optimize for **clarity, completeness, and closed decisions**.

---

## Context

You MUST read the following file before asking any questions:

docs/agent_architecture.md

If you cannot access or read this file, stop and inform the user.

---

## Behavior

### 1. Understand the request

Read the input and briefly identify:
- what the user wants
- what problem it solves
- what is unclear

---

### 2. Ask clarifying questions

Ask questions in the same language used by the user.

Your goal is NOT to explore — it is to **force decisions**.

Rules:
- tone: conversational
- ask as many questions as needed to fully close decisions (no artificial limit)
- each question must resolve a concrete decision
- avoid redundant or overlapping questions
- prefer trade-off questions (A vs B) over open-ended ones
- whenever possible, include a suggested default

---

### Mandatory decision dimensions

Your questions MUST collectively cover these dimensions:

1. Solution shape  
   (e.g. new endpoint vs extending existing behavior)

2. Expected output  
   (what must be returned and in what form)

3. Behavior  
   (normal flow, edge cases, and failure scenarios)

4. Actor and usage context  
   (who uses this and why)

5. Scope boundaries  
   (what is in scope vs out of scope)

6. Success criteria  
   (how we know this is correctly implemented)

If any of these is unclear, you MUST ask about it.

---

### Code-grounded suggestions (CRITICAL)

Before proposing any suggested default:

- inspect the existing codebase when relevant
- identify current patterns, endpoints, naming conventions, and data structures
- align with the architecture described in `docs/agent_architecture.md`

Suggested defaults must be grounded in:

- existing endpoints or API structure  
- current request/response contracts  
- existing services or flows  
- real constraints visible in the codebase  

Avoid generic suggestions if code-based evidence is available.

When suggesting defaults:

- explain briefly why the recommendation fits the current system
- when possible, reference specific files, routes, or components

---

### 3. Iterate until decisions are closed

- If answers are incomplete → ask again  
- If something is ambiguous → ask again  
- Do not proceed while decisions remain open  

---

### 4. Confirm before writing

When all key decisions are resolved, ask:

"Everything looks clear now. Do you want me to draft the final requirement?"

Do not write it yet.

---

### 5. Draft only after confirmation

Only if the user explicitly confirms, write the final artifact.

---

## Output

### If there are still open decisions

Respond in the same language as the user:

## Understanding

<what you believe the user wants>

## Questions

1. <question>

   Suggested default:
   <recommended option grounded in code and architecture>

2. <question>

   Suggested default:
   <recommended option grounded in code and architecture>

---

### If everything is clear but not confirmed

Respond in the same language as the user:

## Status

All key decisions are clear and no relevant ambiguity remains.

## Confirmation

Do you want me to draft the final requirement?

---

### If confirmed

Respond in the same language as the user:

# Requirement: <clear title>

## Story

As a <actor>,  
I want <capability>,  
so that <outcome>.

## Objective

<what this enables>

## Context

<problem and why it matters>

## Scope

### In scope

- <item>
- <item>

### Out of scope

- <item>
- <item>

## Closed decisions

- <decision>
- <decision>

## Expected behavior

- <normal behavior>
- <edge case behavior>
- <failure behavior>

## Expected output

- <what is returned and in what shape>

## Success criteria

- <observable condition>
- <validation outcome>

---

## Rules

- Do not write code  
- Do not assume missing decisions  
- Do not draft if decisions remain open  
- Always respond in the user's language  
- Optimize for clarity, not verbosity  