---
name: joomla-content-import
description: "Use when working with Joomla database import from jos_content and jos_menu tables. Covers the JOIN pattern to find the real meta title (page_title) stored in jos_menu.params JSON field."
---

# Joomla: связь jos_content ↔ jos_menu

## Как найти meta title материала

В Joomla meta title страницы хранится **не в `jos_content`**, а в пункте меню — в JSON-поле `jos_menu.params`.

### Структура связи

```
jos_content.id  →  jos_menu.link
                   "index.php?option=com_content&view=article&id={id}"
```

`jos_menu.params` — JSON-строка, в которой `page_title` и есть настоящий `<title>` страницы:

```json
{
  "page_title": "Курсы CAP CIPA, Обучение, расписание...",
  "menu-meta_description": "",
  "menu-meta_keywords": ""
}
```

### SQL JOIN

```sql
SELECT
    c.id,
    c.title,
    c.alias,
    NULLIF(MIN(JSON_UNQUOTE(JSON_EXTRACT(m.params, '$.page_title'))), '') AS meta_title
FROM jos_content AS c
LEFT JOIN jos_menu AS m
    ON m.link = CONCAT('index.php?option=com_content&view=article&id=', c.id)
   AND m.link LIKE '%view=article&id=%'
WHERE c.catid = ?
GROUP BY c.id
```

**Почему `MIN()` а не просто `JSON_EXTRACT`:**
MariaDB с режимом `ONLY_FULL_GROUP_BY` требует агрегатную функцию для полей вне `GROUP BY`.
`ANY_VALUE()` в старых версиях MariaDB отсутствует — `MIN()` даёт тот же результат.

**Почему `LIKE '%view=article&id=%'` а не `LIKE 'index.php?option=...'`:**
Символ `?` в строке Laravel Query Builder воспринимается как PDO-параметр и подставляет туда значение биндинга (например, `catid`).
