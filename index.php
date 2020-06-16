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
global $PAGE, $USER, $CFG;

$PAGE->set_heading(get_string('pluginname', 'local_contact_form'));


echo $OUTPUT->header();

// var_dump($_SERVER); // get the http_referrer, ip address from here
        // TODO make 2 separate forms for students and staff
        // check here if the're staff or student and display the appropriate form
// look at apprenticeoffjob edit and delete forms
// load in index.php
//call to user table -> department

// either student or academic - staff may be more generic

// Find out if they're a student

// if they are,

// Instantiate the studentform
if (isloggedin() && $USER->id != 1) {
$mform = new enquiryform();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.

	// TODO move this all into locallib

	if(isset($fromform->courselist)) {
		$courselist = $fromform->courselist;
		$courseid = (int)$fromform->courselist;
	} else {
		$courselist = "None";
	}

// $courseid = (int)$fromform->courselist;

// print_object($fromform);
	// $message['body'] =
// TODO put the course in the body too
	$message['body'] = $fromform->comments;
	$message['body'] .= "\r\n";
	$message['body'] .= "Course: " . $courselist;
	$message['body'] .= "\r\n";
	$message['body'] .= "Department: " . $fromform->department;
	$message['body'] .= "\r\n";
	$message['body'] .= "IP Address: " . $_SERVER['HTTP_HOST'];
	$message['body'] .= "\r\n";
	$message['body'] .= "Referring Page: " . $_SERVER["HTTP_REFERER"];
	$message['subject'] = "";
	$message['fromemail'] = $USER->email;

//get which boxes are checked

	$message['subject'] = $fromform->querytype;

	// foreach ($fromform as $form=>$values) {
	// 	if(strpos($form, 'querytype_') !== FALSE ){
 //   			$message['subject'] .= substr($form, strpos($form, "_") + 1)  . ' ';
	// 	}
	// }
// print_object($message);

// TODO set the cc to LTU if it's going to SR
	if($message['subject'] == 'Assessment link missing/dates incorrect' || $message['subject'] == 'Unit_leader_enrolment') {
		$message['emailto'] = get_config('local_contact_form' , 'SRemail');
		$message['cc'] = 	$message['emailto'] = get_config('local_contact_form' , 'LTUemail');

	} else {

		// if($message['subject'])


		$message['emailto'] = get_config('local_contact_form' , 'LTUemail');

	}
	// print_object($message);
//
	create_message($message);
	print_object($message);

	// TODO decide where to redirect to
	redirect($CFG->wwwroot. '/local/contact_form/index.php', get_string('messagesent', 'local_contact_form'), 15);

} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

  //Set default data (if any)
	$toform = "";
  $mform->set_data($toform);
  //displays the form
  $mform->display();
}
} else { // display the logged out form

	$mform = new loggedoutform();

	//Form processing and displaying is done here
	if ($mform->is_cancelled()) {
	    //Handle form cancel operation, if cancel button is present on form
	} else if ($fromform = $mform->get_data()) {
//print_object($fromform);
	// print_object($message);

	$message['body'] = $fromform->problem;
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
	$message['subject'] = get_string('loggedoutsubject', 'local_contact_form');
	$message['fromemail'] = $fromform->email;
	// // $message['emailto'] = 'catherine.newman@solent.ac.uk'; // TODO get this from the settings
	// if 
	// $message['emailto'] = get_config('local_contact_form' , 'LTUemail');

	// print_object($message);

	create_message($message);

	// TODO decide where to redirect to
	redirect($CFG->wwwroot. '/local/contact_form/index.php', get_string('messagesent', 'local_contact_form'), 15);

	  //In this case you process validated data. $mform->get_data() returns data posted in form.
	} else {
	  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
	  // or on the first display of the form.

	  //Set default data (if any)
		// $toform="";
	  // $mform->set_data($fromform);
	  //displays the form
	  $mform->display();
	}


}






echo $OUTPUT->footer();
