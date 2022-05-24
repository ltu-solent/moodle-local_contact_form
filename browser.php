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
 * Device/Browser/OS detection.
 *
 * @package   local_contact_form
 * @author    Mark Sharp <mark.sharp@solent.ac.uk>
 * @copyright 2022 Solent University {@link https://www.solent.ac.uk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We don't require login on this page.
// @codingStandardsIgnoreLine
require_once('../../config.php');

if (!class_exists('WhichBrowser\Parser')) {
    require_once($CFG->dirroot . '/local/contact_form/vendor/autoload.php');
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/contact_form/browser.php');
$PAGE->set_title(get_string('browsercheck', 'local_contact_form'));
$PAGE->set_heading(get_string('browsercheck', 'local_contact_form'));


echo $OUTPUT->header();

$result = new WhichBrowser\Parser(getallheaders());
echo get_string('browserinfo', 'local_contact_form', (object)[
    'browser' => $result->browser->toString(),
    'browserversion' => $result->browser->getVersion(),
    'devicetype' => $result->device->type,
    'os' => $result->os->toString()
]);

echo $OUTPUT->footer();
