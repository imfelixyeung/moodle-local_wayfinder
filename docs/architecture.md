# Architecture

Wayfinder has two layers: PHP backend builds item tree, React frontend renders it.

## PHP Side

### Item Tree

Renderer (`classes/output/renderer.php`) builds this tree:

```
page (root)
├── group "Course module" → navnode items from secondarynav
├── group "Course" → navnode items from secondarynav
├── group "Navigation" → navnode items from primarynav (excludes siteadminnode)
├── group "My profile" → link items from user_get_user_navigation_info()
├── separator
├── command "Language" → submenu page → language options (redirect actions)
└── group "Admin"
    ├── command "Site administration" → submenu page → recursive admin categories
    └── command "Purge all caches" → submenu page → cache options (form actions)
```

### Item Types

| Class | `type` in JSON | Description |
|-------|----------------|-------------|
| `item` | (abstract) | Base. Access check via `check_access()`. |
| `command` | `command` | Has `name`, `description`, `keywords`, `action`, `hotkey`. Main interactable unit. |
| `page` | `command` (subtype `page`) | Command with children. Action is always `submenu`. |
| `group` | `group` | Named container. Access passes if any child accessible. |
| `separator` | `separator` | Visual divider. |
| `link` | `command` (subtype `link`) | Command with redirect action (to URL) + optional keywords. |
| `navnode` | `command` | Wraps a Moodle `navigation_node`. Children become submenu. |

### Action Types

| Class | `id` in JSON | Behavior |
|-------|-------------|----------|
| `redirect` | `redirect` | `window.location.assign(url)` |
| `submenu` | `submenu` | Push page to nav stack, drill down |
| `form` | `form` | POST to URL with data (used for cache purge) |

### Serialization

All items/actions implement `JsonSerializable`. Renderer encodes the entire tree as JSON into `data-react-props` on a `<wayfinder-root>` element.

```html
<wayfinder-root
  data-react-component="@moodle/lms/local_wayfinder/root"
  data-react-props='{"icon":{...},"strings":{...},"root":{...}}'>
  <!-- skeleton HTML -->
</wayfinder-root>
```

## React Side

Moodle's core detects `data-react-component` and mounts the component.

### Component (`root.tsx`)

- Uses **cmdk** library for the command menu UI (dialog, input, list, items)
- Uses **@tanstack/react-hotkeys** for keyboard shortcuts
- Uses **lucide-react** for icons

### State

- `pages[]` -- stack of pages (breadcrumb nav, starts with `[root]`)
- `open` -- dialog visibility
- `value` -- cmdk search value
- `input` -- local input state (aria workaround)

### Flow

1. User presses `Mod+K` or `/` -> palette opens
2. Type filters items via cmdk fuzzy search
3. Select item:
   - `submenu` action / `page` subtype -> push page to `pages[]`, reset search
   - `redirect` -> `window.location.assign(url)`
   - `form` -> create hidden `<form>`, POST, submit
4. Back button or backspace (when empty) -> pop `pages[]`
5. Escape -> close palette

### String Handling

`strings.tsx` provides React context with all language strings. Required strings passed as JSON from PHP renderer.

### Icons

| Scenario | Icon |
|----------|------|
| Item with no action | `Dot` |
| Submenu / page | `ChevronRight` |
| Redirect | `Link2` |
| Form action | `Play` |
