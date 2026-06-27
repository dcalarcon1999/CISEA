# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**SICEA** (Sistema Institucional de Control de Evidencia Audiovisual) is a Laravel web platform that digitalizes the "Libro de Registro de Novedades" (Anexo N° 1, Orden General N° 3192) for managing audiovisual evidence chain of custody at Carabineros de Chile.

## Commands

```bash
# Start development server (Laravel Herd or artisan)
php artisan serve

# Run database migrations
php artisan migrate

# Run migrations with seed data
php artisan migrate --seed

# Run tests
php artisan test

# Run a single test
php artisan test --filter NombreDelTest

# Generate a controller
php artisan make:controller EvidenciaController --resource

# Generate a model with migration
php artisan make:model Evidencia -m

# Generate a FormRequest (for RUC/RIT validation)
php artisan make:request StoreEvidenciaRequest

# Clear cache
php artisan optimize:clear
```

## Architecture

**Pattern:** MVC via Laravel. Routes → Controller → Model → Blade view.

**RBAC — 4 Roles (defined in `app/Models/User.php` and middleware):**
| Role | Permissions |
|---|---|
| Operador | Register daily events (novedades), view own records |
| Personal SIP | Register RUC/RIT extractions, generate delivery acts |
| Jefatura | Read-only reports and custody history |
| Auditor TIC | Read-only access to immutable activity logs |

**Key architectural constraints:**
- `logs_actividad` table is append-only — no `update` or `delete` routes/controllers exist for it. Immutability is enforced at two levels: (1) controller level (no routes exist) and (2) MySQL triggers `logs_actividad_no_update` and `logs_actividad_no_delete` that raise SQLSTATE 45000 on any direct DB attempt.
- RUC and RIT formats are validated via Regex in a `FormRequest` before touching the DB. RUC format: `\d{9}-[\dkK]`. RIT format: `[A-Z]-\d+-\d{4}`.
- Authentication uses `cod_funcionario` + institutional password (not email, not RUT). The `users` table has a `cod_funcionario` column as the unique login identifier.

**Directory layout (Laravel MVC):**
```
app/Http/Controllers/   — one controller per module
app/Http/Middleware/    — RBAC middleware (CheckRole)
app/Models/             — Eloquent models
resources/views/
  layouts/app.blade.php — main shell: sidebar + navbar
  evidencias/           — evidence module views
  auth/                 — login view
routes/web.php          — all application routes
database/migrations/    — table definitions
public/css/sicea.css    — custom overrides on Bootstrap 5
```

## Stack

| Component | Tool |
|---|---|
| Backend | Laravel 10+ (PHP 8.4) |
| Database | MySQL / MariaDB |
| Frontend | Bootstrap 5 |
| Local env | Laravel Herd (macOS) |

## Key Domain Concepts

- **RUC** (Rol Único de Causa): judicial case number assigned by the Ministerio Público. Format: `240012345-K`.
- **RIT** (Rol Interno del Tribunal): court internal docket number. Format: `O-45-2026`.
- **Novedad**: a daily event recorded by an Operator regarding camera access or monitoring.
- **Cadena de Custodia**: the immutable log of every action (view, extraction, delivery) performed on a piece of evidence.
- **Acta de Entrega**: a digital delivery record generated when SIP personnel transfer evidence to the Ministerio Público.

## Critical Rules

- Never add `destroy` or `update` routes/methods to `LogActividad` — this breaks the non-repudiation guarantee.
- All actions on `Evidencia` records must dispatch an observer that writes to `logs_actividad`.
- Blade views extend `layouts.app`; never put navigation markup in individual views.
- Bootstrap 5 classes only — no Bootstrap 4 (no `mr-*`, `ml-*`, `badge-*` legacy classes).
