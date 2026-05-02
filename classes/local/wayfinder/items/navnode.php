<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_wayfinder\local\wayfinder\items;

use core\lang_string;
use core\navigation\navigation_node;
use core\url;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\redirect;
use local_wayfinder\local\wayfinder\actions\submenu;
use local_wayfinder\local\wayfinder\items\command;
use local_wayfinder\output\renderer;

/**
 * Navigation node as a command.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class navnode extends command {
    /** @var navigation_node $node */
    protected navigation_node $node;

    /**
     * Constructor.
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer, navigation_node $node) {
        parent::__construct($renderer);
        $this->node = $node;
    }

    #[\Override]
    public function get_name(): string {
        return $this->node->text ?? $this->node->get_title() ?? new lang_string('unknown');
    }

    #[\Override]
    public function check_access(): bool {
        return $this->node->display;
    }

    #[\Override]
    public function get_action(): ?action {
        $url = $this->node->action();
        $children = $this->node->children;
        if (!count($children)) {
            if (!($url instanceof url)) {
                return null;
            }
            return new redirect($url);
        }

        $items = [
            new link(
                $this->renderer,
                get_string('view') . ' ' . $this->get_name(),
                $url,
            ),
            new separator($this->renderer),
        ];

        /** @var navigation_node $child */
        foreach ($children as $child) {
            $items[] = new self($this->renderer, $child);
        }

        $page = new page($this->renderer, $this->get_name(), $items, false);
        return new submenu($page);
    }
}
