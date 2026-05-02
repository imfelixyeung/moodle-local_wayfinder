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

namespace local_wayfinder\output;

use core\lang_string;
use core\output\html_writer;
use core\output\pix_icon;
use core\output\plugin_renderer_base;
use local_wayfinder\local\wayfinder\item;

/**
 * Wayfinder renderer.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     * Renders root.
     * @return string
     */
    public function render_root(): string {
        // Prevents layout shift with an initial skeleton before React kicks in.
        $skeleton = (string) $this->render_from_template('local_wayfinder/skeleton', []);

        /** @var item[] $items */
        $items = [
            new \local_wayfinder\local\wayfinder\groups\module($this),
            new \local_wayfinder\local\wayfinder\groups\course($this),
            new \local_wayfinder\local\wayfinder\groups\primary($this),
            new \local_wayfinder\local\wayfinder\groups\profile($this),
            new \local_wayfinder\local\wayfinder\items\separator($this),
            new \local_wayfinder\local\wayfinder\commands\core\language($this),
            new \local_wayfinder\local\wayfinder\items\group(
                $this,
                new lang_string('admin'),
                [
                    new \local_wayfinder\local\wayfinder\commands\admin\root($this),
                    new \local_wayfinder\local\wayfinder\commands\admin\purgecaches($this),
                ]
            ),
        ];

        $root = new \local_wayfinder\local\wayfinder\items\page(
            $this,
            new lang_string('pluginname', 'local_wayfinder'),
            $items,
            false
        );

        $stringidentifiers = [
            'cmdk:back',
            'cmdk:dialog:label',
            'cmdk:input:placeholder',
            'cmdk:keys:arrowdown',
            'cmdk:keys:arrowup',
            'cmdk:keys:control',
            'cmdk:keys:enter',
            'cmdk:keys:escape',
            'cmdk:keys:keyk',
            'cmdk:results:empty',
            'cmdk:shortcuts',
            'cmdk:shortcuts:close:label',
            'cmdk:shortcuts:combination:and',
            'cmdk:shortcuts:combination:or',
            'cmdk:shortcuts:enter:label',
            'cmdk:shortcuts:open:label',
            'cmdk:shortcuts:updown:label',
        ];
        $strings = get_strings($stringidentifiers, 'local_wayfinder');

        return html_writer::tag(
            'wayfinder-root',
            $skeleton,
            [
                'data-react-component' => '@moodle/lms/local_wayfinder/root',
                'data-react-props' => json_encode([
                    'icon' => ['html' => $this->render(new pix_icon('a/search', get_string('search')))],
                    'strings' => $strings,
                    'root' => $root,
                ]),
            ]
        );
    }
}
