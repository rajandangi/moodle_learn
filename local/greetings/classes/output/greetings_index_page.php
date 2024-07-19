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

use renderable;
use stdClass;
use templatable;
use renderer_base;

/**
 * Class greetings_index_page
 *
 * @package    local_greetings
 * @copyright  2024 Rajan Dangi {@link https://www.rajandangi.com.np}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class greetings_index_page implements renderable, templatable {
    public function __construct(private array $receiveddata) {
    }
    /**
     * Export data to be used in Mustache template
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->editurl = $this->receiveddata['editurl'];
        $data->deleteurl = $this->receiveddata['deleteurl'];
        return $data;
    }
}
