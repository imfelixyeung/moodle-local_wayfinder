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

use core\lang_string;
use core\url;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\redirect;
use local_wayfinder\output\renderer;

/**
 * Link.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class link extends command {
    /** @var lang_string|string */
    protected lang_string|string $name;

    /** @var url|string */
    protected url|string $url;

    /** @var string[]|null */
    protected ?array $keywords;

    /**
     * Constructor.
     * @param renderer $renderer
     * @param lang_string|string $name
     * @param url|string $url
     * @param string[]|null $keywords
     */
    public function __construct(renderer $renderer, lang_string|string $name, url|string $url, ?array $keywords = []) {
        $this->renderer = $renderer;
        $this->name = $name;
        $this->url = $url;
        $this->keywords = $keywords;
    }

    #[\Override]
    public function get_name(): lang_string|string {
        return $this->name;
    }

    #[\Override]
    public function get_keywords(): ?array {
        return $this->keywords;
    }

    #[\Override]
    public function get_action(): action {
        return new redirect($this->url);
    }
}
