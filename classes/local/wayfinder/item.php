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

use core\context;
use core\context\course;
use JsonSerializable;
use local_wayfinder\output\renderer;

/**
 * Base item.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class item implements JsonSerializable {
    /**
     * Wayfinder plugin renderer.
     * @var renderer
     */
    protected renderer $renderer;

    /**
     * Constructor.
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer) {
        $this->renderer = $renderer;
    }


    /**
     * Get context
     * // phpcs:disable moodle.Commenting.ValidTags.Invalid
     * @param string $context
     * @return context|null
     * @template T of context
     * @phpstan-param class-string<T> $context
     * @phpstan-return T|null $context
     * // phpcs:enable moodle.Commenting.ValidTags.Invalid
     */
    protected function get_context(string $context): ?context {
        $pagecontext = $this->renderer->get_page()->context;
        if (!($pagecontext instanceof $context)) {
            return null;
        }
        return $pagecontext;
    }

    /**
     * Gets course context.
     * @return course|null
     */
    protected function get_context_course(): ?course {
        return $this->get_context(course::class);
    }

    /**
     * Checks if the current user has access to this item.
     * @return bool
     */
    public function check_access(): bool {
        return true;
    }

    /**
     * Filters a given set of items checking user access to the items.
     * @param self[] $items
     * @return self[]
     */
    public static function filter_access(array $items): array {
        $items = array_values(array_filter($items, fn(item $item) => $item->check_access()));
        return $items;
    }
}
