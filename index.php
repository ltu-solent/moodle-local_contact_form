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
 * Contact Form
 *
 * @package    local_contact_form
 * @copyright  2020 onwards Solent University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// phpcs:disable
require_once('../../config.php');
// phpcs:enable
require_once($CFG->libdir . "/formslib.php");
require_once($CFG->dirroot . '/local/contact_form/locallib.php');
require_once($CFG->dirroot . '/local/contact_form/form.php');
if (!class_exists('WhichBrowser\Parser')) {
    require_once($CFG->dirroot . '/local/contact_form/vendor/autoload.php');
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/contact_form/index.php');
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('pluginname', 'local_contact_form'));
global $PAGE, $USER, $CFG;

$PAGE->set_heading(get_string('pluginname', 'local_contact_form'));

// Instantiate the studentform.
if (isloggedin() && $USER->id != 1) {
    $mform = new enquiryform();
    if ($mform->is_cancelled()) {
        redirect($CFG->wwwroot);
    } else if ($fromform = $mform->get_data()) {
        if (isset($fromform->courselist)) {
            $courselist = $fromform->courselist;
            $courseid = (int)$fromform->courselist;
        } else {
            $courselist = null;
        }

        $message['body'] = $fromform->comments;
        $message['body'] .= "\r\n";
        if ($courselist !== null) {
            $message['body'] .= "Course: " . $courselist;
            $message['body'] .= "\r\n";
        }
        $message['body'] .= "Department: " . $fromform->department;
        $message['body'] .= "\r\n";
        $message['body'] .= "IP Address: " . $_SERVER['HTTP_HOST'];
        $message['body'] .= "\r\n";
        $message['body'] .= "Referring Page: " . $_SERVER["HTTP_REFERER"];
        $message['body'] .= "\r\n";

        $result = new WhichBrowser\Parser(getallheaders());
        $message['body'] .= get_string('browserinfo', 'local_contact_form', (object)[
            'browser' => $result->browser->toString(),
            'browserversion' => $result->browser->getVersion(),
            'devicetype' => $result->device->type,
            'os' => $result->os->toString(),
        ]);
        $message['body'] .= "\r\n";

        $message['subject'] = "";
        $message['fromemail'] = $USER->email;

        // Get which boxes are checked.
        $message['subject'] = $fromform->querytype;

        if ($message['subject'] == 'Assessment_Missing_Dates_Incorrect' || $message['subject'] == 'Unit_leader_enrolment') {
            $message['emailto'] = get_config('local_contact_form' , 'SRemail') . ', '
                . get_config('local_contact_form', 'LTUemail') . ', '
                . $message['fromemail'];
        } else {
            $message['emailto'] = get_config('local_contact_form' , 'LTUemail') . ', ' . $message['fromemail'];
        }
        \local_contact_form\create_message($message);
        redirect($CFG->wwwroot. '/local/contact_form/index.php', get_string('messagesent', 'local_contact_form'), 15);

    } else {
        // This branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
        // or on the first display of the form.
        echo $OUTPUT->header();
        $toform = "";
        $mform->set_data($toform);
        $mform->display();
    }
} else {
    // Display the logged out form.
    $mform = new loggedoutform();
    if ($mform->is_cancelled()) {
        redirect($CFG->wwwroot);
    } else if ($fromform = $mform->get_data()) {
        $message['body'] = $fromform->description;
        $message['body'] .= "\r\n";
        $message['body'] .= "Name: " . $fromform->name;
        $message['body'] .= "\r\n";
        $message['body'] .= "Email: " . $fromform->email;
        $message['body'] .= "\r\n";
        $message['body'] .= "Phone: " . $fromform->phone;
        $message['body'] .= "\r\n";
        $message['body'] .= "IP Address: " . $_SERVER['REMOTE_ADDR'];
        $message['body'] .= "\r\n";
        $message['body'] .= "Referring Page: " . $_SERVER["HTTP_REFERER"];

        $result = new WhichBrowser\Parser(getallheaders());
        $message['body'] .= get_string('browserinfo', 'local_contact_form', (object)[
            'browser' => $result->browser->toString(),
            'browserversion' => $result->browser->getVersion(),
            'devicetype' => $result->device->type,
            'os' => $result->os->toString(),
        ]);
        $message['body'] .= "\r\n";

        $message['subject'] = get_string('loggedoutsubject', 'local_contact_form');
        $message['fromemail'] = $fromform->email;
        $message['emailto'] = get_config('local_contact_form' , 'LTUemail') . ', ' . $message['fromemail'];
        \local_contact_form\create_message($message);
        redirect($CFG->wwwroot. '/local/contact_form/index.php', get_string('messagesent', 'local_contact_form'), 15);
    } else {
        echo $OUTPUT->header();
        $mform->display();
    }
}
echo $OUTPUT->footer();
