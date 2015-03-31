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
 * ajax used for saving directly after drag-and-drop
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file      : ajax.php
 * @since     30-3-2015
 * @encoding  : UTF8
 *
 * @package   : block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}
define('NO_DEBUG_DISPLAY', true);

require('../../config.php');
$PAGE->set_url('/blocks/mambo/ajax.php');

require_login(get_site(), true, null, true, true);
$sesskey = required_param('sesskey', PARAM_RAW);

$coursemoduleid = required_param('coursemoduleid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$verb = required_param('verb', PARAM_ALPHANUM);
$action = required_param('action', PARAM_ALPHA);

$systemcontext = context_system::instance();
$array = array('error' => '', 'status' => false);

if (!has_capability('block/mambo:view', $systemcontext)) {
    $array['error'] = get_string('failed:capability_view', 'block_mambo');
} elseif (!confirm_sesskey($sesskey)) {
    $array['error'] = get_string('failed:sesskey', 'block_mambo');
}

if (empty($array['error'])) {

    // load the activities class
    $activities = new \block_mambo\activities();

    switch ($action) {
        case 'delete':
            $activities->delete_activity_map($coursemoduleid);
            $array['status'] = true;
            break;

        case 'add':
            $array['status'] = $activities->add_activity_map($coursemoduleid, $verb, $courseid);
            break;

        default:
            $array['error'] = get_string('failed:unknown_action', 'block_mambo');
            break;
    }
}

echo json_encode($array);