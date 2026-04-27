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
use local_wayfinder\output\renderer;

/**
 * Base wayfinder command.
 *
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @phpstan-type command_json array{type: 'command', name: string, description: string|null, action: action|null}
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
     */
    public function __construct(renderer $renderer) {
        $this->renderer = $renderer;
    }

    /**
     * Gets the name of the command.
     * @return lang_string
     */
    public function get_name(): lang_string {
        return new lang_string('unknown');
    }

    /**
     * Gets the description of the command.
     * @return lang_string|null
     */
    public function get_description(): ?lang_string {
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
     * {@inheritDoc}
     * @return command_json
     */
    public function jsonSerialize(): array {
        return [
            'type' => 'command',
            'name' => (string) $this->get_name(),
            'description' => $this->get_description()?->out(),
            'action' => $this->get_action(),
        ];
    }
}
