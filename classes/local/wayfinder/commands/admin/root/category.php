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

namespace local_wayfinder\local\wayfinder\commands\admin\root;

use core\lang_string;
use local_wayfinder\local\wayfinder\items\link;
use local_wayfinder\local\wayfinder\items\page;
use local_wayfinder\local\wayfinder\items\separator;
use local_wayfinder\output\renderer;

/**
 * A category item.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class category extends page {
    /** @var \admin_category */
    private \admin_category $category;

    /**
     * Constructor.
     * @param renderer $renderer
     * @param \admin_category $category
     */
    public function __construct(renderer $renderer, \admin_category $category) {
        $this->category = $category;

        $items = [
            new link(
                $renderer,
                new lang_string('admincategory', 'admin', $category->visiblename),
                $category->get_settings_page_url(),
            ),
            new separator(),
        ];
        $children = $this->category->get_children();
        foreach ($children as $child) {
            if ($child instanceof \admin_externalpage || $child instanceof \admin_settingpage) {
                if ($child->is_hidden() || !$child->check_access()) {
                    continue;
                }
                $items[] = new link($renderer, $child->visiblename, $child->get_settings_page_url());
                continue;
            }

            if ($child instanceof \admin_category) {
                if ($child->is_hidden() || !$child->check_access()) {
                    continue;
                }
                if (!$child->get_children()) {
                    $items[] = new link($renderer, $child->visiblename, $child->get_settings_page_url());
                    continue;
                }
                $items[] = new self($renderer, $child);
                continue;
            }
        }

        parent::__construct($renderer, $category->visiblename, $items, false);
    }

    #[\Override]
    public function get_name(): string {
        return $this->category->visiblename;
    }

    #[\Override]
    public function get_keywords(): ?array {
        return [$this->category->name];
    }
}
