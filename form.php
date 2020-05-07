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


require_once("$CFG->libdir/formslib.php");



class enquiryform extends moodleform {
    //Add elements to formif
    public function definition() {
        global $CFG, $USER, $DB;


        // print(key($usertype));

// 
        // print_r($usertype);

        // if (key($usertype) == $student) {
// check if they're a studeent
        // see https://moodle.org/mod/forum/discuss.php?d=257611

        if (user_has_role_assignment($USER->id,5)){
            $courses = get_student_courses();
            $querytypes = array("Access/account/password", "Assessment", "Enrollment", "Other");
            
        } else { // for now, they're staff
            $querytypes = array("Assessment link missing/dates incorrect", "Assessment other", "Unit leader enrolment", "Other");
        }
        // print_object($usertype);

// start the form
        $mform = $this->_form; // Don't forget the underscore!

        $checkarray=array();

        foreach($querytypes as $querytype) {
          // IMPORTANT: add validation and type rules as per documentation
          $checkarray[] = $mform->createElement('checkbox', 'querytype_' . $querytype, $querytype);
        }
        $mform->addGroup($checkarray, 'checkar', '', array(' '), false);

// add current modules here in a dropdown
         if (user_has_role_assignment($USER->id,5)){
        	$coursenames = array();
            // $courses = get_student_courses();
            foreach ($courses as $course => $data) {
        	   // array_push($coursenames, $data->fullname);
        	   $coursenames[$data->shortname] = $data->fullname;
            }
        }
        // print_r($coursenames);

        $mform->addElement('select', 'courselist', get_string('courselistlabel', 'local_contact_form'), $coursenames);
        // Add comments section
        $mform->addElement('textarea', 'comments', get_string('description', 'local_contact_form'), 'wrap="virtual" rows="20" cols="50"');

        $this->add_action_buttons($cancel=true, $submitlabel=get_string('savechanges', 'local_contact_form'));



        // $mform->addElement('text', 'email', get_string('email')); // Add elements to your form
        // $mform->setType('email', PARAM_NOTAGS);                   //Set type of element

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}

class staff_form extends moodleform {
    //Add elements to formif
    public function definition() {
        global $CFG, $USER, $DB;

// start the form
                $mform = $this->_form; // Don't forget the underscore!

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
}
