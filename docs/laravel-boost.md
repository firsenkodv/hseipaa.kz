# Laravel Boost — Установка и Skills

## 1. Установка пакета

```bash
composer require laravel/boost --dev
```

## 2. Инициализация

```bash
php artisan boost:install
```

В интерактивном меню:
- `↑` `↓` — навигация
- `Space` — выбрать пункт
- `Enter` — подтвердить

Доступные фичи: `guidelines`, `skills`, `mcp`

## 3. Установка skill

```bash
php artisan boost:add-skill <owner/repo> --skill <skill-name>
```

Пример:
```bash
php artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist
```

## 4. Директория skills

Все доступные skills: https://skills.laravel.cloud

---

> Важно: `boost:add-skill` — это отдельная команда, не вводить в меню `boost:install`.
