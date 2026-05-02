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

use JsonSerializable;

/**
 * Presents hotkey, e.g. Control+S.
 * // phpcs:ignore moodle.Commenting.ValidTags.Invalid
 * @phpstan-type hotkey_json array{
 *     type: 'hotkey',
 *     key: string,
 *     mod?: true,
 *     ctrl?: true,
 *     shift?: true,
 *     alt?: true,
 *     meta?: true,
 * }
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hotkey implements JsonSerializable {
    /**
     * Constructor.
     */
    public function __construct(
        /**
         * Modified key.
         * @var string $key
         */
        public readonly string $key,
        /**
         * Requires platform adaptive key held, Meta on Mac, Control otherwise.
         * @var bool $mod
         */
        public readonly bool $mod = false,
        /**
         * Requires Control key held.
         * @var bool $ctrl
         */
        public readonly bool $ctrl = false,
        /**
         * Requires Shift key held.
         * @var bool $shift
         */
        public readonly bool $shift = false,
        /**
         * Requires Alt key held
         * @var bool $alt
         */
        public readonly bool $alt = false,
        /**
         * Requires Meta key held.
         * @var bool $meta
         */
        public readonly bool $meta = false,
    ) {
    }

    /**
     * {@inheritDoc}
     * @return hotkey_json
     */
    public function jsonSerialize(): array {
        /** @var hotkey_json $data */
        $data = [
            'type' => 'hotkey',
            'key' => $this->key,
        ];

        if ($this->mod) {
            $data['mod'] = true;
        }
        if ($this->ctrl) {
            $data['ctrl'] = true;
        }
        if ($this->shift) {
            $data['shift'] = true;
        }
        if ($this->alt) {
            $data['alt'] = true;
        }
        if ($this->meta) {
            $data['meta'] = true;
        }

        return $data;
    }
}
