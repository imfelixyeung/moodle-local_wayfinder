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

use core\url;
use local_wayfinder\local\wayfinder\action;

/**
 * Form action.
 *
 * // phpcs:disable moodle.Commenting.ValidTags.Invalid
 * @phpstan-type form_data array<string, string>
 * @phpstan-type form_json array{type:'action', id: string, url: string, data: form_data}
 * // phpcs:enable moodle.Commenting.ValidTags.Invalid
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class form extends action {
    /** @var url $url Url to redirect to. */
    protected url $url;

    /** @var array<string, string>  */
    protected array $data;

    /**
     * Constrictor.
     * @param url $url
     * @param array<string, string> $data
     */
    public function __construct(url $url, array $data) {
        $this->url = $url;
        $this->data = $data;
    }

    #[\Override]
    protected static function get_id(): string {
        return 'form';
    }

    /**
     * {@inheritDoc}
     * @return form_json
     */
    #[\Override]
    public function jsonSerialize(): array {
        $json = parent::jsonSerialize();
        $json['url'] = $this->url->out(false);
        $json['data'] = $this->data;
        return $json;
    }
}
