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

namespace local_wayfinder\local\wayfinder\actions;

use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\item;
use local_wayfinder\local\wayfinder\separator;

/**
 * Submenu action.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class submenu extends action {
    /**
     * Array of items to display.
     * @var array
     */
    protected array $items;

    /**
     * Constrictor.
     * @param (item|separator)[] $items
     */
    public function __construct(array $items) {
        $this->items = $items;
    }

    #[\Override]
    protected static function get_id(): string {
        return 'submenu';
    }

    #[\Override]
    public function jsonSerialize() {
        $json = parent::jsonSerialize();
        $json['items'] = $this->items;
        return $json;
    }
}
