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

/**
 * Lib.
 *
 * @package   local_wayfinder
 * @copyright 2026 Felix Yeung
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\output\pix_icon;
use core\output\renderer_base;

/**
 * Adds the wayfinder component to navigation.
 * @param renderer_base $renderer
 * @return string
 */
function local_wayfinder_render_navbar_output(renderer_base $renderer) {
    // Prevents layout shift with an initial skeleton before React kicks in.
    $skeleton = $renderer->render_from_template('local_wayfinder/skeleton', []);

    return html_writer::tag(
        'wayfinder-root',
        $skeleton,
        [
            'data-react-component' => '@moodle/lms/local_wayfinder/root',
            'data-react-props' => json_encode([
                'icon' => ['html' => $renderer->render(new pix_icon('a/search', get_string('search')))],
                'strings' => [
                    'cmdk:dialog:label' => get_string('cmdk:dialog:label', 'local_wayfinder'),
                    'cmdk:input:placeholder' => get_string('cmdk:input:placeholder', 'local_wayfinder'),
                    'cmdk:results:empty' => get_string('cmdk:results:empty', 'local_wayfinder'),
                ],
                'list' => [
                    ['name' => get_string('profile')],
                    ['name' => get_string('grades', 'grades')],
                    ['name' => get_string('calendar', 'core_calendar')],
                    ['name' => get_string('privatefiles')],
                    ['name' => get_string('reports', 'core_reportbuilder')],
                    ['name' => get_string('preferences')],
                    ['name' => get_string('language')],
                    ['name' => get_string('switchroleto')],
                    ['name' => get_string('logout')],
                ],
            ]),
        ]
    );
}
