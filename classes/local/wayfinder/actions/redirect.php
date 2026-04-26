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
 * redirect action.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class redirect extends action {
    /** @var url $url Url to redirect to. */
    protected url $url;

    /**
     * Constrictor.
     * @param url $url
     */
    public function __construct(url $url) {
        $this->url = $url;
    }

    #[\Override]
    protected static function get_id(): string {
        return 'redirect';
    }

    #[\Override]
    public function jsonSerialize() {
        $json = parent::jsonSerialize();
        $json['url'] = $this->url->out(false);
        return $json;
    }
}
