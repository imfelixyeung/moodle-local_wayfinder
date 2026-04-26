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

namespace local_wayfinder\local\wayfinder\items\admin\purgecaches;

use core\lang_string;
use core\url;
use local_wayfinder\local\wayfinder\action;
use local_wayfinder\local\wayfinder\actions\form;
use local_wayfinder\local\wayfinder\item;
use local_wayfinder\output\renderer;

/**
 * Purge a specific cache (or all caches).
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class option extends item {
    /** @var string|null */
    private ?string $cache;

    /**
     * Constructor.
     * @param string|null $cache
     * @param renderer $renderer
     */
    public function __construct(renderer $renderer, ?string $cache) {
        parent::__construct($renderer);
        $this->cache = $cache;
    }

    #[\Override]
    public function get_name(): lang_string {
        return match ($this->cache) {
            null => new lang_string('purgecaches', 'admin'),
            'theme' => new lang_string('purgethemecache', 'admin'),
            'courses' => new lang_string('purgecoursecache', 'admin'),
            'lang' => new lang_string('purgelangcache', 'admin'),
            'js' => new lang_string('purgejscache', 'admin'),
            'template' => new lang_string('purgetemplates', 'admin'),
            'filter' => new lang_string('purgefiltercache', 'admin'),
            'muc' => new lang_string('purgemuc', 'admin'),
            'other' => new lang_string('purgeothercaches', 'admin'),
            default => new lang_string('unknown'),
        };
    }

    #[\Override]
    public function get_action(): ?action {
        $baseurl = new url('/admin/purgecaches.php');
        $commondata = [
            '_qf__core_admin_form_purge_caches' => '1',
            'sesskey' => sesskey(),
            'returnurl' => $this->renderer->get_page()->url->out(false),
        ];

        if (!$this->cache) {
            return new form($baseurl, [...$commondata, 'all' => '1']);
        }

        return new form($baseurl, [
            ...$commondata,
            'purgeselectedcaches' => '1',
            "purgeselectedoptions[$this->cache]" => '1',
        ]);
    }
}
