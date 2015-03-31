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
 * 
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file: view.php
 * @since 30-3-2015
 * @encoding: UTF8
 *
 * @package: block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_login();

$courseid = required_param('courseid', PARAM_INT); // if no courseid is given
$parentcourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($courseid);
$systemcontext = context_system::instance();

$PAGE->set_course($parentcourse);

$PAGE->set_url('/blocks/mambo/view.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('activitiespage', 'block_mambo'));
$PAGE->navbar->add(get_string('activitiespage', 'block_mambo'));
$PAGE->requires->css('/blocks/mambo/styles.css');

// load drag-and-drop js module
block_mambo_add_javascript_module();

// load activities class
$activities = new \block_mambo\activities();

// load html render
$renderer = $PAGE->get_renderer('block_mambo');

//get all behaviours available in mambo
$behaviours = \block_mambo\behaviours::get_all();

// sending moodle header
echo $OUTPUT->header();

if(!$activities->has_completion($COURSE))
{
    print_error("disablecompletion", 'block_mambo');
}
else if(!has_capability('block/mambo:view', $systemcontext))
{
    print_error("failed:capability_view", 'block_mambo');
}
echo $renderer->activities_overview($activities , $behaviours, $COURSE);

// sending moodle footer
echo $OUTPUT->footer();