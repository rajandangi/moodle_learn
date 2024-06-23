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
 * TODO describe file deletepost
 *
 * @package    local_dbapis
 * @copyright  2024 2024 Catalyst IT {@link http://www.catalyst-au.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

require_login();
require_sesskey();

$id = required_param('id', PARAM_INT);
$returnurl = required_param('returnurl', PARAM_TEXT);

$DB->delete_records('local_dbapis', ['id' => $id]);

redirect($returnurl, get_string('postdeleted', 'local_dbapis'), 2, \core\output\notification::NOTIFY_SUCCESS);
