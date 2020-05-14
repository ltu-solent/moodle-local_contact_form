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


// Check if they're logged in, if not do the non logged in form

        // TODO store this in a variable

        $usertype = get_user_type();

        // print_object($usertype);

        if($usertype !== 'student'){

            $querytypes = array("Access/account/password", "Assessment", "Enrollment", "Other");
        } else { // for now, they're staff
            $querytypes = array("Assessment link missing/dates incorrect", "Assessment other", "Unit leader enrolment", "Other");
        }

        // TODO get the department and set it as a hidden field

// start the form
        $mform = $this->_form; // Don't forget the underscore!
        $checkarray=array();

        // store the department in a hidden field
        $mform->addElement('hidden','department', $usertype);
        $mform->setType('department', PARAM_RAW );

        foreach($querytypes as $querytype) {
          // IMPORTANT: add validation and type rules as per documentation
          $checkarray[] = $mform->createElement('checkbox', 'querytype_' . $querytype, $querytype);
        }

        // array_unshift($checkarray, 'Select');

        $mform->addGroup($checkarray, 'checkar', 'Query type:', array(' '), false);

// add current modules here in a dropdown

        // TODO read this from the variable
        // TODO pass this value as a hidden field
         if($usertype == 'student'){
        	$coursenames = array();
            $courses = get_student_courses();
            foreach ($courses as $course => $data) {
        	   $coursenames[$data->shortname] = $data->fullname;
          }
        array_unshift($coursenames , 'Select');

          // print_object($usertype);

          // print_object($coursenames);

          $mform->addElement('select', 'courselist', get_string('courselistlabel', 'local_contact_form'), $coursenames);
        }
        // Add comments section
        $mform->addElement('textarea', 'comments', get_string('description', 'local_contact_form'), 'wrap="virtual" rows="20" cols="50"');

        $this->add_action_buttons($cancel=true, $submitlabel=get_string('savechanges', 'local_contact_form'));

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}

class loggedoutform extends moodleform {
    //Add elements to formif
    public function definition() {
        global $CFG, $USER, $DB;

        // start the form
        $mform = $this->_form; // Don't forget the underscore!
        $mform->addElement('text', 'name', get_string('name',  'local_contact_form'));
        $mform->addRule('name', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->setType('name', PARAM_TEXT );

        $mform->addElement('text', 'email', get_string('email',  'local_contact_form'));
        $mform->setType('email', PARAM_NOTAGS );
        $mform->addRule('email', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('email', get_string('erremail', 'local_contact_form'), 'email', null, 'server', 1, 0);

        $mform->addElement('text', 'phone', get_string('phone',  'local_contact_form'));
        $mform->setType('phone', PARAM_RAW );
        $mform->addRule('phone', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('phone', get_string('errnumeric', 'local_contact_form'), 'numeric', null, 'server', 1, 0);

        // Add comments section
        $mform->addElement('textarea', 'problem', get_string('problem', 'local_contact_form'), 'wrap="virtual" rows="20" cols="50"');
        $mform->addRule('problem', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('problem', get_string('minlength', 'local_contact_form'), 'minlength', 20, 'client');

        // TODO add keys to config and pass correct variables
        $mform->addElement('recaptcha', 'recaptcha_element', 'RECAPTCHA');


        // add the send button
        $this->add_action_buttons($cancel=true, $submitlabel=get_string('savechanges', 'local_contact_form'));
}
    //Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $recaptchaelement = $this->_form->getElement('recaptcha_element');

        if (!empty($this->_form->_submitValues['g-recaptcha-response'])) {
            $response = $this->_form->_submitValues['g-recaptcha-response'];
            if (!$recaptchaelement->verify($response)) {
                $errors['recaptcha_element'] = get_string('incorrectpleasetryagain', 'auth');
            }
        } else {
            $errors['recaptcha_element'] = get_string('missingrecaptchachallengefield');
        }
        foreach($data as $k=>$v){
            if(strpos($k, 'loggedoutform') !== false){
                if(floor($v) != $v){
                    $errors[$k] = get_string('errnumeric', 'local_contact_form');
                }
            }
        }

      return $errors;
    }
}
