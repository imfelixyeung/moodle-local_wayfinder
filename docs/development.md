# Development

## JS Build

Uses Bun. Source in `js/esm/src/`. Build output in `js/esm/build/`.

```bash
# Install deps
bun install

# Build for production
bun run build

# Dev watch mode
bun run dev
```

If using npm instead:

```bash
npm install
npm run build
npm run dev
```

### Dependencies

| Package | Version | Use |
|---------|---------|-----|
| `cmdk` | ^1.1.1 | Command palette UI |
| `@tanstack/react-hotkeys` | ^0.10.0 | Keyboard shortcuts |
| `lucide-react` | ^1.11.0 | Icons |

## SCSS

Source: `styles.scss`. Compiled to `styles.css`:

```bash
sass --no-source-map styles.scss:styles.css
```

## PHPStan

```bash
phpstan analyze -c phpstan.neon
```

Level 8. Uses `micaherne/phpstan-moodle` extension.

## CI

GitHub Actions (`.github/workflows/moodle-ci.yaml`):

- PHP 8.3 & 8.4
- Moodle 502
- PostgreSQL 16 & MariaDB 10
- PHP Lint, PHPMD, PHPCS, PHPDoc
- Validation, Savepoints, Mustache Lint
- Grunt, PHPUnit, Behat

## File Layout

```
classes/
  output/renderer.php       - Builds item tree, renders root
  local/wayfinder/
    item.php                - Abstract base item
    action.php              - Base action
    hotkey.php              - Hotkey definition
    items/                  - Item types (command, group, page, link, separator, navnode)
    actions/                - Action types (redirect, submenu, form)
    commands/               - Built-in commands (admin, purgecaches, language)
    groups/                 - Built-in groups (primary, course, module, profile)
js/esm/src/
  root.tsx                  - Main React component
  strings.tsx               - Language string context
templates/
  skeleton.mustache         - Initial HTML (hidden search icon)
```
