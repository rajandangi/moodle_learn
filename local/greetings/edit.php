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
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2023 Rajan Dangi <rajandangi649@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/local/greetings/lib.php');

// Set the system context for this page.
$context = context_system::instance();
$PAGE->set_context($context);

// Set the Page Url.
$PAGE->set_url(new moodle_url('/local/greetings/index.php'));

// Use Standard Page Layout.
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('editmessage', 'local_greetings'));

// Check if the user is logged in.
require_login();

// Prevent guest users from accessing the page.
if (isguestuser()) {
    throw new moodle_exception('noguest');
}

$id = required_param('id', PARAM_INT);

$result = $DB->get_record('local_greetings_messages', ['id' => $id]);
if (!$result) {
    throw new moodle_exception('norecordfound', 'local_greetings');
}


$deletepost = has_capability('local/greetings:deleteownmessage', $context);
$deleteanypost = has_capability('local/greetings:deleteanymessages', $context);
$canedit = $deleteanypost || ($deletepost && $result->userid == $USER->id);

// Create Instance of message form by passing $result as a customdata.
$messageform = new local_greetings\form\message_form('', ['message' => $result]);

// Update the message if the form is submitted.
if ($canedit && $data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $result->message = $message;

        $DB->update_record('local_greetings_messages', $result);

        redirect($PAGE->url, get_string('messageupdated', 'local_greetings'), null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

// If the user cannot edit, redirect them before outputting any content.
if ($canedit) {
    // Display the Page Output.
    echo $OUTPUT->header();

    // Display the Message Form.
    $messageform->display();

    echo $OUTPUT->footer();
} else {
    redirect($PAGE->url, get_string('cannoteditmessage', 'local_greetings'), null, \core\output\notification::NOTIFY_ERROR);
}
