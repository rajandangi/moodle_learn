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
 * Form for editing HTML block instances.
 *
 * @package   block_testblock
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_testblock extends block_base
{
    function init()
    {
        $this->title = get_string('pluginname', 'block_testblock');
    }

    function has_config()
    {
        return true;
    }

    public function get_content()
    {
        global $DB;

        if ($this->content !== null) {
            return $this->content;
        }

        $content = '';

        // Get the configuration value from the settings page for this block
        $show_courses = get_config('block_testblock', 'showcourses');
        if ($show_courses) {
            $courses = $DB->get_records('course');
            foreach ($courses as $course) {
                $content .= $course->fullname . '<br> ';
            }
        } else {
            $users = $DB->get_records('user');
            foreach ($users as $user) {
                $content .= $user->username . ' ' . $user->lastname . '<br>';
            }
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->content->footer = 'Footer here...';

        return $this->content;
    }
}
