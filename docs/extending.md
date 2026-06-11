# Extending

Add new items, commands, groups, or actions.

## Add Command

Create class in `classes/local/wayfinder/commands/`. Extend `items\command`:

```php
namespace local_wayfinder\local\wayfinder\commands\myfeature;

use local_wayfinder\local\wayfinder\items\command;
use local_wayfinder\local\wayfinder\actions\redirect;

class mycommand extends command {
    public function __construct(renderer $renderer) {
        parent::__construct($renderer, 'My Command', 'Does something cool');
        $this->set_keywords(['cool', 'thing']);
        $this->set_action(new redirect('https://moodle.local/my/cool/page.php'));
    }

    public function check_access(): bool {
        return has_capability('some/capability', $this->get_context());
    }
}
```

Register in `renderer.php` `render_root()`.

## Add Group

Create class in `classes/local/wayfinder/groups/`. Extend `items\group`:

```php
namespace local_wayfinder\local\wayfinder\groups\mygroup;

use local_wayfinder\local\wayfinder\items\group;

class mygroup extends group {
    public function __construct(renderer $renderer) {
        $items = [];
        // Build items from some data source.
        $items[] = new \local_wayfinder\local\wayfinder\commands\myfeature\mycommand($renderer);
        parent::__construct($renderer, 'My Group', $items);
    }
}
```

## Add Action

Create class in `classes/local/wayfinder/actions/`. Extend `action`:

```php
namespace local_wayfinder\local\wayfinder\actions\myaction;

use local_wayfinder\local\wayfinder\action;

class myaction extends action {
    public function __construct(
        private readonly string $url,
    ) {}

    protected static function get_id(): string {
        return 'myaction';
    }

    public function jsonSerialize(): array {
        return parent::jsonSerialize() + ['url' => $this->url];
    }
}
```

Then handle in React `onCommandSelected` in `root.tsx`.

## Item Types Reference

| Class | Extends | Use when |
|-------|---------|----------|
| `command` | `item` | Single selectable action |
| `page` | `command` | Command with sub-items (drill-down) |
| `group` | `item` | Named section of items |
| `link` | `command` | Quick link to URL |
| `navnode` | `command` | Wrap Moodle navigation_node |
| `separator` | `item` | Visual divider |
