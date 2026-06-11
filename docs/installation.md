# Installation

## Requirements

- Moodle 5.2.0+
- PHP 8.3+
- Composer
- Node/npm or Bun (for JS build)

## Install

1. Copy `local/wayfinder/` to your Moodle `local/` directory.
2. Install PHP deps:
    ```bash
    composer install
    ```
3. Install JS deps and build:
    ```bash
    bun install && bun run build
    # or: npm install && npm run build
    ```
4. Visit Site admin > Notifications to install.
5. No settings page -- just works. Look for search icon in navbar.

## Dev Install

If editing JS, run watcher:

```bash
bun run dev
# or: npm run dev
```
