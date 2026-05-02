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
use core\navigation\navigation_node;
use local_wayfinder\local\wayfinder\items\navnode;
use local_wayfinder\local\wayfinder\items\group;
use local_wayfinder\output\renderer;

/**
 * Primary navigation group.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class primary extends group {
    /**
     * Constructor.
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer) {
        $items = [];

        /** @var navigation_node[] $nodes */
        $nodes = $renderer->get_page()->primarynav->children;

        foreach ($nodes as $node) {
            // Skip site admin because we have a custom admin root tree command separately.
            if ($node->key === 'siteadminnode') {
                continue;
            }
            $items[] = new navnode($renderer, $node);
        }

        parent::__construct($renderer, new lang_string('navigation'), $items);
    }
}
