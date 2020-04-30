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

class local_contact_form extends moodleform {
    //Add elements to formif
    public function definition() {
        global $CFG, $USER, $DB;
        var_dump($USER->id);

        $roleassignments = $DB->get_records('role_assignments', ['userid' => $USER->id]);
        print('xxx');
        print_r($roleassignments);
        print('xxx');

        // TODO get list of checkboxes for staff/students from settings

        // check if the user has the role 'student' i.e. 5
        if (user_has_role_assignment($USER->id,5)) {
        	print("yes");
        	$querytypes = array("access", "assessment", "enrolment", "other");
        } else {
// they're logged in so they must be staff?? TODO check this!
	       	$querytypes = array("accessment link", "assessment other", "unit leader enrolment", "other");


        	print("NO");
        }
// start the form
        $mform = $this->_form; // Don't forget the underscore! 
        foreach($querytypes as $querytype) {
       // IMPORTANT: add validation and type rules as per documentation
            // Add the assignment name

        	$mform->addElement('advcheckbox', 'querytype', $querytype, 'Label displayed after checkbox', array('group' => 1), array(0, 1));

 
    }


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