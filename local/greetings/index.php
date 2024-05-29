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
$PAGE->set_title(get_string('pluginname', 'local_greetings'));
$PAGE->set_heading(get_string('pluginname', 'local_greetings'));

// Create Instance of message form.
$messageform = new local_greetings\form\message_form();

// Save the Form Data if submitted.
if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass();
        $record->message = $message;
        $record->timecreated = time();

        $DB->insert_record('local_greetings_messages', $record);
    }
}

// Display the Page Output.
echo $OUTPUT->header();

if (isloggedin()) {
    echo local_greetings_get_greeting($USER);
} else {
    echo get_string('greetinguser', 'local_greetings');
}

// Display the Message Form.
$messageform->display();

// Get all the messages from the database.
$messages = $DB->get_records('local_greetings_messages');

// Display the Messages.
echo $OUTPUT->box_start('card-columns');
foreach ($messages as $m) {
    echo html_writer::start_tag('div', ['class' => 'card']);
    echo html_writer::start_tag('div', ['class' => 'card-body']);

    echo html_writer::tag('p', $m->message, ['class' => 'card-text']);

    echo html_writer::start_tag('p', ['class' => 'card-text']);
    echo html_writer::tag('small', userdate($m->timecreated), ['class' => 'text-muted']);
    echo html_writer::end_tag('p');

    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');
}
echo $OUTPUT->box_end();

echo $OUTPUT->footer();
