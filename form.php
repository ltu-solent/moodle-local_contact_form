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

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

/**
 * Enquiry form for logged in users
 */
class enquiryform extends moodleform {
    /**
     * Form definitions
     *
     * @return void
     */
    public function definition() {
        global $CFG, $USER, $DB, $PAGE;
        $PAGE->requires->js_call_amd('local_contact_form/radiobuttons', 'init');
        // Check if they're logged in, if not do the non logged in form.
        $usertype = \local_contact_form\get_user_type();
        if ($usertype == 'student') {
            $querytypes = [
                "Access/account/password" => "Access/account/password",
                "Assessment" => "Assessment",
                "Enrollment" => "Enrollment",
                "Student_Other" => "Other"
            ];
        } else {
            // They're staff.
            $querytypes = [
                "Assessment_Missing_Dates_Incorrect" => "Assessment link missing/dates incorrect",
                "Assessment_Other" => "Assessment other",
                "Unit_leader_enrolment" => "Unit leader enrolment",
                "Staff_Other" => "Other"
            ];
        }

        $mform = $this->_form;
        // Store the department in a hidden field.
        $mform->addElement('hidden', 'department', $usertype);
        $mform->setType('department', PARAM_ALPHANUMEXT);

        foreach ($querytypes as $querytype => $q) {
            // IMPORTANT: add validation and type rules as per documentation.
            $radioarray[] = $mform->createElement('radio', 'querytype', '', $q, $querytype);
        }

        $mform->addGroup($radioarray, 'radioar', 'Query type:', array(' '), false);
        $mform->addRule('radioar', get_string('required', 'local_contact_form'), 'required', null, 'client', 1, 0);

        if ($usertype == 'student') {
            $coursenames = array();
            $courses = \local_contact_form\get_student_courses();
            foreach ($courses as $course => $data) {
                $coursenames[$data->shortname] = $data->fullname;
            }
            array_unshift($coursenames , 'Select');

            $mform->addElement('select', 'courselist', get_string('courselistlabel', 'local_contact_form'), $coursenames);

        }

        // Add a static element to display information.
        $mform->addElement('static', 'Additional text', '', '<div id="querytypehelp"></div>');

        // Add comments section.
        $mform->addElement('textarea', 'comments', get_string('description', 'local_contact_form'),
            'wrap="virtual" rows="20" cols="50"');
        $mform->addRule('comments', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('comments', get_string('minlength', 'local_contact_form'), 'minlength', 20, 'client');

        $mform->addElement('static', 'additionaldata', new lang_string('additionaldata', 'local_contact_form'),
            new lang_string('additionaldata_desc', 'local_contact_form'));

        $this->add_action_buttons(true, get_string('savechanges', 'local_contact_form'));

    }

    /**
     * {@inheritDoc}
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK (true allowed for backwards compatibility too).
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if (isset($data['querytype_Assessment']) && $data['courselist'] === '0') {
            $errors['querytype_Assessment'] = get_string('errselected', 'local_contact_form');
        }
        return $errors;
    }
}


/**
 * Form for logged out users
 */
class loggedoutform extends moodleform {

    /**
     * Form definition
     *
     * @return void
     */
    public function definition() {
        $a = new stdClass();
        $a->linktext = get_string('unitytext', 'local_contact_form');
        $a->linkurl = get_string('unityurl', 'local_contact_form');
        $a->linkemail = get_config('local_contact_form' , 'LTUemail');

        $mform = $this->_form;
        $mform->addElement('text', 'name', get_string('name',  'local_contact_form'));
        $mform->addRule('name', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->setType('name', PARAM_TEXT );
        $mform->addElement('text', 'solentusername', get_string('solentusername', 'local_contact_form'));
        $mform->setType('solentusername', PARAM_TEXT);

        $mform->addElement('text', 'email', get_string('email',  'local_contact_form'));
        $mform->setType('email', PARAM_NOTAGS );
        $mform->addRule('email', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('email', get_string('erremail', 'local_contact_form'), 'email', null, 'server', 1, 0);

        $mform->addElement('text', 'phone', get_string('phone',  'local_contact_form'));
        $mform->setType('phone', PARAM_RAW );
        $mform->addRule('phone', get_string('errnumeric', 'local_contact_form'), 'numeric', null, 'server', 1, 0);

        $mform->addElement('static', 'infotext',
            get_string('loggedoutinfotext_label', 'local_contact_form'),
            get_string('loggedoutinfotext', 'local_contact_form', $a));
        $mform->setType('infotext', PARAM_TEXT);

        // Add comments section.
        $mform->addElement('textarea', 'description', get_string('description', 'local_contact_form'),
            'wrap="virtual" rows="20" cols="50"');
        $mform->addRule('description', get_string('required', 'local_contact_form'), 'required', null, 'server', 1, 0);
        $mform->addRule('description', get_string('minlength', 'local_contact_form'), 'minlength', 20, 'client');

        $mform->addElement('recaptcha', 'recaptcha_element', 'RECAPTCHA');

        $mform->addElement('static', 'additionaldata', new lang_string('additionaldata', 'local_contact_form'),
            new lang_string('additionaldata_desc', 'local_contact_form'));

        $this->add_action_buttons(true, get_string('savechanges', 'local_contact_form'));
    }

    /**
     * {@inheritDoc}
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK (true allowed for backwards compatibility too).
     */
    public function validation($data, $files) {
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
        foreach ($data as $k => $v) {
            if (strpos($k, 'loggedoutform') !== false) {
                if (floor($v) != $v) {
                    $errors[$k] = get_string('errnumeric', 'local_contact_form');
                }
            }
        }
        return $errors;
    }
}
