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

namespace local_wayfinder\local\wayfinder\items\admin;

use core\context\system;
use core\lang_string;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\submenu;
use local_wayfinder\local\wayfinder\item;
use local_wayfinder\local\wayfinder\items\admin\purgecaches\option;
use local_wayfinder\local\wayfinder\separator;

/**
 * Purge cache.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class purgecaches extends item {
    #[\Override]
    public function get_name(): lang_string {
        return new lang_string('purgecachespage', 'admin');
    }

    #[\Override]
    public function check_access(): bool {
        return has_capability('moodle/site:config', system::instance());
    }

    #[\Override]
    public function get_action(): ?action {
        $caches = ['theme', 'courses', 'lang', 'js', 'template', 'filter', 'muc', 'other'];
        $items = [
            new option($this->renderer, null),
            new separator(),
            ...array_map(fn(?string $cache) => new option($this->renderer, $cache), $caches),
        ];
        return new submenu($items);
    }
}
