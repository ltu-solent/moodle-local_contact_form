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
 * This file defines the admin settings for this plugin
 *
 * @package   local_contact_form
 * @copyright 2020 Solent University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$settings = new admin_settingpage('local_contact_form', new lang_string('pluginname', 'local_contact_form'));
if ($hassiteconfig) {
    $settings->add(new admin_setting_configtext('local_contact_form/LTUemail', 'LTU email address', '', ''));
    $settings->add(new admin_setting_configtext('local_contact_form/SRemail', 'Student Registry email address', '', ''));
    $settings->add(new admin_setting_configtext('local_contact_form/SHemail', 'Student Hub email address', '', ''));

    $ADMIN->add('localplugins', $settings);
}