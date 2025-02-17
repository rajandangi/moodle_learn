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

namespace local_greetings\output;

use plugin_renderer_base;

/**
 * Renderer for Greetings
 *
 * @package    local_greetings
 * @copyright  2024 Rajan Dangi {@link https://www.rajandangi.com.np}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     * Render the layout test page
     *
     * @param mixed $page
     * @return string
     */
    public function render_layout_test_page($page): string {
        $data = $page->export_for_template($this);
        return parent::render_from_template('local_greetings/layout-test', $data);
    }

    /**
     * Render the greetings index page
     *
     * @param mixed $page
     * @return string
     */
    public function render_greetings_index_page($page): string {
        $data = $page->export_for_template($this);
        return parent::render_from_template('local_greetings/index', $data);
    }
}
