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
 * Language file
 *
 * @package   local_contact_form
 * @author    Mark Sharp <mark.sharp@solent.ac.uk>
 * @copyright 2022 Solent University {@link https://www.solent.ac.uk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['Access/account/password'] = 'If you cannot log into a Solent system please check if you are being asked to enter an email address for the username. Your email address is your Solent username@solent.ac.uk. For example 4SMITJ12@solent.ac.uk for the username 4SMITJ12. All passwords across Solent systems are the same. Click here to visit the <a href="https://passwordreset.microsoftonline.com">Password Self-Service</a> page.';
$string['Assessment'] = 'If you cannot submit and you have an <span style="color:red"><b>URGENT</b></span> deadline please email your assignment to <a href=mailto:"ltu@solent.ac.uk">ltu@solent.ac.uk</a> and copy in your tutor. In other cases, look at the help resources for <a href="https://learn.solent.ac.uk/submitting-files"> submitting files</a>, <a href="https://learn.solent.ac.uk/submitting-myportfolio">submitting myPortfolio</a>, <a href="https://learn.solent.ac.uk/submitting-video-audio">submitting video/audio</a>. ';
$string['Assessment_Missing_Dates_Incorrect'] = 'Please enter full details including Module Codes, Start dates of Modules, Assessment link Names and due dates. Once processed by Student Registry this will automatically update in SOL.';
$string['Assessment_Other'] = 'Firstly check the steps in the <a href="https://learn.solent.ac.uk/mod/resource/view.php?id=1366027">Assessment Checklist</a>. If your query isn\'t answered, please check the <a href="https://learn.solent.ac.uk/staff-help">Assignments section in Staff Help</a>. If this still doesn\'t resolve your question please supply Module Codes, start dates of modules and assessment link names.';

$string['Enrollment'] = 'Please supply full details of the page(s) you are expecting to see and if possible start dates. Enrolments may take up to 24 hours after full registration, to show on SOL.';

$string['Staff_Other'] = 'Click here for help with <a href="https://learn.solent.ac.uk/staff-help">general help with using SOL</a><br>
    Click here for <a href="https://learn.solent.ac.uk/getting-started">help getting started with SOL</a><br>
    Click here for help with content: <a href="https://learn.solent.ac.uk/solbaseline">the online SOL Baseline course</a><br>
    Click here for <a href="https://learn.solent.ac.uk/panopto-getting-started">help with lecture Capture</a><br>
    Click here for <a href="https://learn.solent.ac.uk/zoom-account">help with using Zoom</a><br><br>
    If your query relates to account issues, software requests or classroom or desktop hardware please contact ICT through <a href="http://unity.solent.ac.uk">UNITY</a>';
$string['Student_Other'] = 'If you have a SOL query, please supply as many details as possible including a contact number if you need to speak to somebody. Please check our <a href="https://learn.solent.ac.uk/student-faqs">student FAQs</a> or check the <a href="https://learn.solent.ac.uk/student-help">help section in SOL</a>.<br><br>
    If your query relates to:<br>
    Questions about your course<br>
    Wellbeing<br>
    Student funding questions<br>
    To whom it may concern letters,<br>
    Council tax exemption certificates<br>
    Bank letters<br>
    Replacement campus cards<br>
    References<br>
    Advice on regulations, processes and policy.<br>
    Telephone please contact the Student Hub on:<br>
    Email: <a href=mailto:"student.hub@solent.ac.uk"> student.hub@solent.ac.uk</a><br>
    Telephone: 023 8201 5200';

$string['Unit_leader_enrolment'] = 'If you need to enrol as Module Leader on the following Modules:<br><br>
    EDU117, EDU118, EDU120 and PDU022<br>
    Module codes containing HHS, HSW and PDU<br>
    Module names containing \'counselling\' and \'social work\'<br><br>
    Please enter full details of the module codes, start dates and Module Leader name.<br><br>
    For help with all other module enrolments, please use <a href="https://learn.solent.ac.uk/staff-self-service">staff enrolment self-service</a>.<br><br>
    If you are already enrolled as a tutor on the module, please un-enrol and then use enrolment self-service to process the request. Once requested if you require immediate access, use self-service to re-enrol as a tutor as well whilst waiting for the update.';

$string['additionaldata'] = 'Additional data';
$string['additionaldata_desc'] = 'When you submit this form, your IP address and information ' .
    'about your device and operating system will also be sent. This will help us diagnose technical issues, if relevant. ' .
    'By clicking "Send query" you agree to this.';

$string['bottomcontent'] = 'This is the content we want to show at the bottom of the page';
$string['bottomlabel'] = 'Label for bottom content';
$string['browsercheck'] = 'Browser check';
$string['browserinfo'] = 'You are using {$a->browser} on {$a->os} {$a->devicetype}.';

$string['courselistlabel'] = 'If applicable please select the page you are contacting us about';

$string['description'] = 'Please describe your query with as many details as possible including alternative contact details if required';

$string['email'] = 'Alternative Email ';
$string['erremail'] = 'Must be a vaild email address';
$string['errnumeric'] = 'Must be a number';
$string['errselected'] = 'Please select a course/module';

$string['loggedoutinfotext'] = '<p><strong>Students:</strong> If your query relates to:</p>' .
    '<ul>' .
    '<li>Questions about your course</li>' .
    '<li>Wellbeing</li>' .
    '<li>Student funding questions</li>' .
    '<li>To whom it may concern letters,</li>' .
    '<li>Council tax exemption certificates</li>' .
    '<li>Bank letters</li>' .
    '<li>Replacement campus cards</li>' .
    '<li>References</li>' .
    '<li>Advice on regulations, processes and policy</li>' .
    '</ul>' .
    '<p>Please contact Student Hub. Email: <a href=mailto:"{$a->linkemail}">{$a->linkemail}</a> Telephone: 023 8201 5200</p>' .
    '<p><strong>Staff:</strong> If your query relates to account issues,  software requests or classroom or desktop hardware, ' .
    'please contact ICT through <a href="{$a->linkurl}">{$a->linktext}</a></p>';
$string['loggedoutinfotext_label'] = "Helpful information";
$string['loggedoutsubject'] = 'Logged out enquiry';

$string['messagesent'] = 'Your message has been sent. You will receive a copy by email';
$string['minlength'] = 'Please enter a minimum of 20 characters';

$string['name'] = 'Name: ';

$string['passwordlink'] = 'https://passwordreset.microsoftonline.com/';
$string['passwordtext'] = 'Password Self-Service';
$string['phone'] = 'Phone ';
$string['pluginname'] = 'Contact Form';
$string['problem'] = 'Please enter details of the problem you are experiencing or of your enquiry';

$string['required'] = 'Required field';

$string['savechanges'] = 'Send query';
$string['solentusername'] = 'Solent Username';

$string['unitytext'] = 'UNITY';
$string['unityurl'] = 'http://unity.solent.ac.uk';
$string['unknown'] = 'Unknown';
