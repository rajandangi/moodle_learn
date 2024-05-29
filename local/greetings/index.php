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

use core_reportbuilder\local\helpers\format_test;

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

// Check if the user is logged in.
require_login();

// Prevent guest users from accessing the page.
if (isguestuser()) {
    throw new moodle_exception('noguest');
}

// Create Instance of message form.
$messageform = new local_greetings\form\message_form();

// Save the Form Data if submitted.
if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass();
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

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
$userfields = \core_user\fields::for_name()->with_identity($context);
$userfieldssql = $userfields->get_sql('u');

$sql = "SELECT m.id, m.message, m.timecreated, m.userid
      {$userfieldssql->selects}
      FROM {local_greetings_messages} m
      LEFT JOIN {user} u ON u.id=m.userid
      ORDER BY timecreated DESC";

$messages = $DB->get_records_sql($sql);

// Display the Messages.
echo $OUTPUT->box_start('card-columns');
foreach ($messages as $m) {
    echo html_writer::start_tag('div', ['class' => 'card']);
    echo html_writer::start_tag('div', ['class' => 'card-body']);

    echo html_writer::tag('p', format_text($m->message, FORMAT_PLAIN), ['class' => 'card-text']);

    echo html_writer::start_tag('p', ['class' => 'card-text']);
    echo html_writer::tag('p', get_string('postedby', 'local_greetings', $m->firstname), ['class' => 'card-text']);
    echo html_writer::tag('small', userdate($m->timecreated), ['class' => 'text-muted']);
    echo html_writer::end_tag('p');

    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');
}
echo $OUTPUT->box_end();

echo $OUTPUT->footer();
