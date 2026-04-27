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

namespace local_wayfinder\local\wayfinder;

use core\lang_string;

/**
 * Page.
 *
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @phpstan-type page_json array{type: 'page', name: string, items: item[]}
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class page extends item {
    /**
     * Name of the page.
     * @var lang_string
     */
    protected lang_string $name;
    /**
     * Array of items to display.
     * @var item[]
     */
    protected array $items;

    /**
     * Constructor.
     * @param lang_string $name
     * @param item[] $items
     */
    public function __construct(lang_string $name, array $items) {
        $this->name = $name;
        $this->items = $items;
    }

    /**
     * {@inheritDoc}
     * @return page_json
     */
    public function jsonSerialize(): array {
        return [
            'type' => 'page',
            'name' => (string) $this->name,
            'items' => self::filter_access($this->items),
        ];
    }
}
