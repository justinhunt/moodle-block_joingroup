<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * joingroup block settings
 *
 * @package   block_joingroup
 * @copyright 2025 justin@poodll.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Control background display and icons.
    $options = [
        'group' => get_string('group', 'block_joingroup'),
        'teacher' => get_string('teacher', 'block_joingroup'),
        'instructor' => get_string('instructor', 'block_joingroup'),
        'team' => get_string('team', 'block_joingroup'),
        'class' => get_string('class', 'block_joingroup'),
        'school' => get_string('school', 'block_joingroup'),
        'house' => get_string('house', 'block_joingroup'),
        'room' => get_string('room', 'block_joingroup'),
        'department' => get_string('department', 'block_joingroup'),
        'circle' => get_string('circle', 'block_joingroup'),
        'company' => get_string('company', 'block_joingroup'),
    ];
    $settings->add(
        new admin_setting_configselect(
            'block_joingroup/jointhing',
            get_string('jointhing', 'block_joingroup'),
            get_string('jointhing_desc', 'block_joingroup'),
            'group',
            $options
        )
    );

}
