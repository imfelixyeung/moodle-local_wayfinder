# Usage

## Hotkeys

| Key | Action |
|-----|--------|
| `Ctrl+K` / `Cmd+K` | Open palette |
| `/` | Open palette |
| `Escape` | Close palette |
| `Backspace` | Go back (when input empty) |
| `↑` `↓` | Navigate results |
| `Enter` | Select item |

## Search

Type to fuzzy-search all visible commands. Cmdk handles the search -- matches names, descriptions, and keywords.

## Nav Tree

Palette has sections:

### Navigation
Primary nav links from Moodle navbar (site admin node excluded -- has its own section).

### Course
Course-level secondary nav. Only shows when inside a course.

### Course module
Module-level secondary nav. Only shows when inside a module activity.

### My profile
User profile links from `user_get_user_navigation_info()`.

### Language
Switch language. Only shows when >1 language installed. Options redirect to current page with `?lang=XX`.

### Site administration
Full admin tree. Browse categories. Each category page has a "Settings page" link + sub-items. Recursive -- drill down as deep as admin tree goes.

### Purge all caches
Individual cache purge options, each with hotkeys:

| Cache | Hotkey |
|-------|--------|
| All caches | `Mod+A` |
| Theme | `Mod+T` |
| Courses | -- |
| Language | `Mod+L` |
| JS | `Mod+J` |
| Template | -- |
| Filter | -- |
| MUC | -- |
| Other | `Mod+O` |
