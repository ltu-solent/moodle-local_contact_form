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
 * @package    local
 * @subpackage contact_form
 * @copyright  2020 onwards Solent University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('locallib.php');
require_once('form.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/contact_form/index.php');
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('pluginname', 'local_contact_form'));
global $PAGE, $USER;

if (isloggedin() && $USER->id != 1) {
$PAGE->set_heading($USER->firstname . ' ' . $USER->lastname . ' - ' . get_string('pluginname', 'local_contact_form'));
} else {
  $PAGE->set_heading(get_string('pluginname', 'local_contact_form'));
}

echo $OUTPUT->header();
        // TODO make 2 separate forms for students and staff
        // check here if the're staff or student and display the appropriate form
// look at apprenticeoffjob edit and delete forms 
// load in index.php
//call to user table -> department

// either student or academic - staff may be more generic

// Find out if they're a student

// if they are, 

// Instantiate the studentform 
$mform = new student_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.
	var_dump($fromform);

$courseid = (int)$fromform->courselist;
	

	$message['body'] = $fromform->comments;
	$message['fromemail'] = $USER->email;
	$message['emailto'] = 'abc@abc.com'; // TODO get this from the settings
	$message['subject'] = get_course_fullname($courseid);

// print('x' . $courseid . 'x');

	


	create_message($message);
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

  //Set default data (if any)
	$toform = "";
  $mform->set_data($toform);
  //displays the form
  $mform->display();
}







echo $OUTPUT->footer();