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

use core\context;
use core\context\course;
use core\lang_string;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\item;
use local_wayfinder\output\renderer;

/**
 * Base wayfinder command.
 *
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @phpstan-type command_json array{
 *     type: 'command',
 *     name: string,
 *     description: string|null,
 *     keywords: string[]|null,
 *     action: action|null,
 * }
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class command extends item {
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
     * Gets the name of the command.
     * @return lang_string|string
     */
    public function get_name(): lang_string|string {
        return new lang_string('unknown');
    }

    /**
     * Gets the description of the command.
     * @return lang_string|string|null
     */
    public function get_description(): lang_string|string|null {
        return null;
    }

    /**
     * Gets the description of the command.
     * @return string[]|null
     */
    public function get_keywords(): ?array {
        return null;
    }

    /**
     * Gets the action of the command.
     * @return ?action
     */
    public function get_action(): ?action {
        return null;
    }

    /**
     * Get context
     * // phpcs:ignore
     * @template T of context
     * @param class-string<T> $context
     * @return T|null
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
     * {@inheritDoc}
     * @return command_json
     */
    public function jsonSerialize(): array {
        return [
            'type' => 'command',
            'name' => (string) $this->get_name(),
            'description' => (string) $this->get_description(),
            'keywords' => $this->get_keywords(),
            'action' => $this->get_action(),
        ];
    }
}
