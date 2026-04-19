# Task Brief: Filtro de agenda de conciertos

## Objective

Add server-side filters (band, city, date) to the `agenda` view (`type=agenda`) of the concerts section. The filter form renders as a horizontal bar on desktop and a collapsible block on mobile. All other views are unchanged.

**Out of scope:** `entradas`, `entrada`, `normal` views; AJAX; saved filters; admin panel.

## Input assumptions and prerequisites

- PHP site, no framework. Existing pattern: GET params → `ob_page::get_param()` → template.
- DB timestamp format: `YYYYMMDDHHMMSS` (numeric, no separators). Must match existing `timestamp_actual()` output pattern.
- Escaping: `$bd->real_escape_string()` is the established pattern.
- No automated test suite. Validation is manual browser testing.
- Approved High-Level Technical Contract: `ia/.agents/doc_ai_planning_mode.md` workflow.

## Files to create/update

| File | Action |
|---|---|
| `sources/ob_page.php` | Modify `get_param()` and `navegador()` |
| `sources/ob_conciertos_web.php` | Modify `extreure_concerts_per_data_concert()`, `mostrar_resultats_per_data_concert()`, add `construir_filtres_agenda_sql()`, `get_agenda_count()` |
| `templates/conciertos.php` | Modify agenda case: add filter form, update count query |
| `css/conciertos.css` | Add desktop filter styles |
| `css/responsive.css` | Add mobile filter styles |

---

## Phase 1 — ob_page.php: parse filter params

- [ ] T1.1 In `get_param()`, after the `concert_tipus` validation block (after the `if ($this->concert_tipus != 'normal' && ...)` block, before `if (isset($param['id']))`), add:

```php
if ($this->concert_tipus == 'agenda') {
    $this->filtro_banda = isset($param['banda']) ? trim(substr($param['banda'], 0, 100)) : '';
    $this->filtro_ciudad = isset($param['ciudad']) ? trim(substr($param['ciudad'], 0, 100)) : '';
    $valid_fecha_tipos = ['hoy', 'semana', 'mes', 'libre'];
    $this->filtro_fecha_tipo = (isset($param['fecha_tipo']) && in_array($param['fecha_tipo'], $valid_fecha_tipos)) ? $param['fecha_tipo'] : '';
    $fecha_libre_raw = isset($param['fecha_libre']) ? $param['fecha_libre'] : '';
    $fecha_parsed = DateTime::createFromFormat('Y-m-d', $fecha_libre_raw);
    $this->filtro_fecha_libre = ($fecha_parsed && $fecha_parsed->format('Y-m-d') === $fecha_libre_raw) ? $fecha_libre_raw : '';
} else {
    $this->filtro_banda = '';
    $this->filtro_ciudad = '';
    $this->filtro_fecha_tipo = '';
    $this->filtro_fecha_libre = '';
}
```

## Phase 2 — ob_page.php: navegador() filter params

- [ ] T2.1 In `navegador()`, in each of the 4 link blocks (max_prev, prev, next, max_next), immediately after `print '&type=' . $this->concert_tipus;`, add:

```php
if ($this->concert_tipus == 'agenda') {
    if ($this->filtro_banda != '') print '&banda=' . urlencode($this->filtro_banda);
    if ($this->filtro_ciudad != '') print '&ciudad=' . urlencode($this->filtro_ciudad);
    if ($this->filtro_fecha_tipo != '') print '&fecha_tipo=' . $this->filtro_fecha_tipo;
    if ($this->filtro_fecha_tipo == 'libre' && $this->filtro_fecha_libre != '') print '&fecha_libre=' . $this->filtro_fecha_libre;
}
```

## Phase 3 — ob_conciertos_web.php: SQL helper + count method

- [ ] T3.1 Add private method `construir_filtres_agenda_sql($bd, $filtres)` that returns a WHERE extra string based on active filters (banda LIKE, localitat LIKE, dateConcert range). Date ranges use `YYYYMMDD000000` format.

- [ ] T3.2 Add public method `get_agenda_count($bd, $filtres = [])` that runs the count query with base filter (`dateConcert >= now`) plus `construir_filtres_agenda_sql()` and returns `num_rows`.

- [ ] T3.3 Modify `extreure_concerts_per_data_concert($bd, $punter, $quantitat, $tipo, $filtres = [])`: add 5th param, call `construir_filtres_agenda_sql()`, append to WHERE. Store `$this->filtres_agenda = $filtres`.

- [ ] T3.4 In `mostrar_resultats_per_data_concert()`, after the for-loop, when `$this->numero_resultats == 0` AND `$tipo == 'agenda'` AND `$this->filtres_agenda` is non-empty, print language-appropriate message. ES: "No se encontraron conciertos con estos filtros." CAT: "No s'han trobat concerts amb aquests filtres."

## Phase 4 — templates/conciertos.php: filter form + count query

- [ ] T4.1 In the `agenda` case, before the `$basedades->conectar()` call, render:
  - `<div id="filtres_agenda">` containing a toggle button `<div id="filtres_agenda_mobile_toggle">` and the form `<div id="filtres_agenda_form">`.
  - Form: hidden inputs for `ln`, `sec`, `type=agenda`; text input for `banda`; text input for `ciudad`; radio group for `fecha_tipo` (values: '', 'hoy', 'semana', 'mes', 'libre'); date input for `fecha_libre`; submit button.
  - All inputs pre-filled from `$page->filtro_*`.
  - If any filter is active: show "Ver todos" / "Veure tots" link back to unfiltered agenda.

- [ ] T4.2 Pass `$filtres` array to `extreure_concerts_per_data_concert()` as 5th argument.

- [ ] T4.3 Replace the count query (`SELECT idGig FROM concertsdata`) with a call to `$concerts->get_agenda_count($basedades->bd, $filtres)`. Pass result to `$page->navegador()`.

## Phase 5 — CSS desktop

- [ ] T5.1 In `css/conciertos.css`, add styles for `#filtres_agenda`, `#filtres_agenda_mobile_toggle` (hidden on desktop), `#filtres_agenda_form`, form inputs, submit button, "Ver todos" link.

## Phase 6 — CSS mobile

- [ ] T6.1 In `css/responsive.css`, inside the `@media (max-width: 1023px)` block, add:
  - `#filtres_agenda_mobile_toggle { display: block; }` (visible on mobile)
  - `#filtres_agenda_form { display: none; }` (hidden by default on mobile)
  - `#filtres_agenda_form.filtres_open { display: block !important; }` (shown when toggled)
  - `#filtres_agenda_form form { flex-direction: column; }` (stack vertically)
  - Toggle button: full-width, themed.

---

## Validation steps

| # | Scenario | Expected | Type |
|---|---|---|---|
| V1 | Open agenda with no filters | Same as current (no regression) | required |
| V2 | Filter by band (partial text) | Only matching concerts show | required |
| V3 | Filter by city (partial text) | Only matching concerts show | required |
| V4 | Shortcut "hoy" | Only today's concerts | required |
| V5 | Shortcut "semana" | This week's concerts | required |
| V6 | Shortcut "mes" | This month's concerts | required |
| V7 | Free date input | Concerts on that day only | required |
| V8 | Band + city combined | AND intersection | required |
| V9 | No results | Language message shown, no pagination | required |
| V10 | Paginate filtered | Filter params in pagination links | required |
| V11 | Mobile toggle | Form collapses/expands; layout intact | required |
| V12 | Desktop filter bar | Visible above list; no layout breakage | required |

---

## Implementing agent self-check loop

Before marking delivery complete, the implementing agent must:
1. Verify filter params appear in URL after form submit.
2. Verify filtered results match expected DB values.
3. Verify pagination links include active filter params.
4. Verify mobile toggle works without JS errors.
5. Verify no layout regression in `normal`, `entradas`, `entrada` views.

## Risks and rollback

- `navegador()` has 4 identical-looking link blocks; missing one causes pagination to lose filter params on that nav action. Verify all 4.
- The count query must match the data query exactly. A mismatch causes wrong total page count.
- Rollback: `git revert` the commit or restore from git history. No DB changes.

## Done criteria

- All V1–V12 validation scenarios pass in browser.
- Filter params appear in URL and are preserved in pagination.
- No regression in other views.
- Empty results message displayed in correct language.

---

## Execution Report (to be completed by implementing agent)

### Summary
- Total execution tasks: 10
- Completed: <number>
- Blocked: <number>
- Skipped: <number>

### Task Status
- [ ] T1.1
- [ ] T2.1
- [ ] T3.1
- [ ] T3.2
- [ ] T3.3
- [ ] T3.4
- [ ] T4.1
- [ ] T4.2
- [ ] T4.3
- [ ] T5.1
- [ ] T6.1

### Validation Executed
- [ ] V1 No-filter regression
- [ ] V2 Band filter
- [ ] V3 City filter
- [ ] V4 Hoy shortcut
- [ ] V5 Semana shortcut
- [ ] V6 Mes shortcut
- [ ] V7 Free date
- [ ] V8 Combined filters
- [ ] V9 No results message
- [ ] V10 Pagination with filters
- [ ] V11 Mobile toggle
- [ ] V12 Desktop layout

### Blockers
- None

### Files Changed
- sources/ob_page.php
- sources/ob_conciertos_web.php
- templates/conciertos.php
- css/conciertos.css
- css/responsive.css

### Final Statement
- [ ] All non-blocked tasks completed
- [ ] All required validations executed
- [ ] Optional validations either executed or explicitly marked as skipped
- [ ] No behavior beyond the approved contract was introduced
