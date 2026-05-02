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
            new \local_wayfinder\local\wayfinder\items\group(
                $this,
                new lang_string('myprofile'),
                [
                    new \local_wayfinder\local\wayfinder\commands\user\profile($this),
                    new \local_wayfinder\local\wayfinder\commands\grade\grades($this),
                    new \local_wayfinder\local\wayfinder\commands\calendar\calendar($this),
                    new \local_wayfinder\local\wayfinder\commands\user\files($this),
                    new \local_wayfinder\local\wayfinder\commands\user\preferences($this),
                ]
            ),
            new \local_wayfinder\local\wayfinder\items\separator($this),
            new \local_wayfinder\local\wayfinder\commands\reportbuilder\reports($this),
            new \local_wayfinder\local\wayfinder\commands\core\language($this),
            new \local_wayfinder\local\wayfinder\commands\course\switchrole($this),
            new \local_wayfinder\local\wayfinder\commands\core\logout($this),
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

        return html_writer::tag(
            'wayfinder-root',
            $skeleton,
            [
                'data-react-component' => '@moodle/lms/local_wayfinder/root',
                'data-react-props' => json_encode([
                    'icon' => ['html' => $this->render(new pix_icon('a/search', get_string('search')))],
                    'strings' => [
                        'cmdk:dialog:label' => get_string('cmdk:dialog:label', 'local_wayfinder'),
                        'cmdk:input:placeholder' => get_string('cmdk:input:placeholder', 'local_wayfinder'),
                        'cmdk:results:empty' => get_string('cmdk:results:empty', 'local_wayfinder'),
                    ],
                    'root' => $root,
                ]),
            ]
        );
    }
}
