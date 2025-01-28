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
 * Contact Form locallib
 *
 * @package    local_contact_form
 * @copyright  2020 onwards Solent University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_contact_form;

/**
 * Get user type (department field) for current user.
 *
 * @return string
 */
function get_user_type() {
    global $DB, $USER;
    $department = $DB->get_field('user', 'department', ['id' => $USER->id]);
    return $department;
}


/**
 * Get student courses for current user
 * @return array Course list
 */
function get_student_courses() {
    global $DB, $USER;
    $courses = $DB->get_records_sql(
        "SELECT DISTINCT e.courseid, c.shortname, c.fullname, c.startdate, c.enddate, cc.name categoryname
        FROM {enrol} e
        JOIN {user_enrolments} ue ON ue.enrolid = e.id AND ue.userid = ?
        JOIN {course} c ON c.id = e.courseid
        JOIN {course_categories} cc ON cc.id = c.category
        WHERE ue.status = 0 AND e.status = 0 AND ue.timestart < UNIX_TIMESTAMP()
        AND (ue.timeend = 0 OR ue.timeend > UNIX_TIMESTAMP())
        AND ue.userid = ?
        AND cc.idnumber LIKE 'courses_%' OR cc.idnumber LIKE 'modules_%'", [$USER->id, $USER->id]);
    return $courses;
}

/**
 * Create message
 *
 * @param array $message fields including body, emailto, subject and fromemail
 * @return void
 */
function create_message($message) {
    $messagebody = $message['body'];
    $to = $message['emailto'];
    $subject = $message['subject'];
    $headers = "From: " . $message['fromemail'] . "\r\n";
    mail($to, $subject, $messagebody, $headers);
}
