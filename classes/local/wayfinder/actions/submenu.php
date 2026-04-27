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
use local_wayfinder\local\wayfinder\page;

/**
 * Submenu action.
 *
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @phpstan-type submenu_json array{type:'action', id: string, page: page}
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class submenu extends action {
    /**
     * Page to dispay.
     * @var page
     */
    protected page $page;

    /**
     * Constructor.
     * @param page $page
     */
    public function __construct(page $page) {
        $this->page = $page;
    }

    #[\Override]
    protected static function get_id(): string {
        return 'submenu';
    }

    /**
     * {@inheritDoc}
     * @return submenu_json
     */
    #[\Override]
    public function jsonSerialize(): array {
        $json = parent::jsonSerialize();
        $json['page'] = $this->page;
        return $json;
    }
}
