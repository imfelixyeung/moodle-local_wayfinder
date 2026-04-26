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

namespace local_wayfinder\local\wayfinder\items\core\language;

use core\lang_string;
use core\url;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\redirect;
use local_wayfinder\local\wayfinder\item;
use local_wayfinder\output\renderer;

/**
 * Switch to a specific language.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class option extends item {
    /** @var string */
    private string $lang;

    /**
     * Constructor.
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer, string $lang) {
        parent::__construct($renderer);
        $this->lang = $lang;
    }

    #[\Override]
    public function get_name(): lang_string {
        return new lang_string('thislanguage', 'langconfig', lang: $this->lang);
    }

    #[\Override]
    public function get_description(): lang_string {
        return new lang_string('thislanguageint', 'langconfig', lang: $this->lang);
    }

    #[\Override]
    public function get_action(): ?action {
        return new redirect(new url($this->renderer->get_page()->url, ['lang' => $this->lang]));
    }
}
