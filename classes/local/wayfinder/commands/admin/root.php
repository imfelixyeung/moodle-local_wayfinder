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

namespace local_wayfinder\local\wayfinder\commands\admin;

use core\context\system;
use core\lang_string;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\submenu;
use local_wayfinder\local\wayfinder\commands\admin\root\category;
use local_wayfinder\local\wayfinder\items\command;

/**
 * Purge cache.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class root extends command {
    #[\Override]
    public function get_name(): lang_string {
        return new lang_string('administrationsite');
    }

    #[\Override]
    public function check_access(): bool {
        return has_capability('moodle/site:config', system::instance());
    }

    #[\Override]
    public function get_action(): ?action {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');
        /** @var \admin_root $root */
        $root = admin_get_root(reload: false, requirefulltree: false);
        $page = new category($this->renderer, $root);
        return new submenu($page);
    }
}
