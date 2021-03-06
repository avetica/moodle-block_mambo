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
 * map your activities with mambo behaviours
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_login();

$courseid = required_param('courseid', PARAM_INT); // If no courseid is given.
$blockid = required_param('blockid', PARAM_INT); // If no courseid is given.
$parentcourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($courseid);
$blockcontext = context_block::instance($blockid , MUST_EXIST);

$PAGE->set_course($parentcourse);

$PAGE->set_url('/blocks/mambo/view.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('activitiespage', 'block_mambo'));
$PAGE->navbar->add(get_string('activitiespage', 'block_mambo'));
$PAGE->requires->css('/blocks/mambo/styles.css');

// Load drag-and-drop js module.
block_mambo_add_javascript_amd_module();

$config = get_config('block_mambo');

// Sending moodle header.
echo $OUTPUT->header();

if (empty($config->site)) {
    print_error("site_missing", 'block_mambo');
}

// Load activities class.
$activities = new \block_mambo\activities();

// Load html render.
$renderer = $PAGE->get_renderer('block_mambo');

// Get all behaviours available in mambo.
$behaviours = \block_mambo\behaviours::get_all();

if (!$activities->has_completion($COURSE)) {
    print_error("disablecompletion", 'block_mambo');
}
else if (!has_capability('block/mambo:view', $blockcontext)) {
    print_error("failed:capability_view", 'block_mambo');
}
echo $renderer->activities_overview($activities , $behaviours, $COURSE);

// Sending moodle footer.
echo $OUTPUT->footer();
