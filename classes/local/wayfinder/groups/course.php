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

namespace local_wayfinder\local\wayfinder\groups;

use core\lang_string;
use local_wayfinder\local\wayfinder\items\navnode;
use local_wayfinder\local\wayfinder\items\group;
use local_wayfinder\output\renderer;

/**
 * Course group.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course extends group {
    /**
     * Constructor.
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer) {
        $items = [];

        $nodes = $renderer->get_page()->secondarynav->children;

        foreach ($nodes as $node) {
            $items[] = new navnode($renderer, $node);
        }

        parent::__construct($renderer, new lang_string('course'), $items);
    }

    #[\Override]
    public function check_access(): bool {
        if (!$this->get_context_course()) {
            return false;
        }

        return parent::check_access();
    }
}
