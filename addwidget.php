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
 * build your own widget templates
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   : block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/addwidget_form.php');
require_login();

$courseid = required_param('courseid', PARAM_INT); // If no courseid is given.
$blockid = required_param('blockid', PARAM_INT); // If no courseid is given.
$widgetid = optional_param('widgetid', false, PARAM_INT); // If no courseid is given.
$action = optional_param('action', false, PARAM_ALPHA);
$parentcourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$context = context_course::instance($courseid);
$blockcontext = context_block::instance($blockid, MUST_EXIST);

$PAGE->set_course($parentcourse);

$PAGE->set_url('/blocks/mambo/addwidget.php' , array('blockid' => $blockid,  'widgetid' => $widgetid, 'courseid' => $courseid));
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('addwidget', 'block_mambo'));
$PAGE->navbar->add(get_string('addwidget', 'block_mambo'));
$PAGE->requires->css('/blocks/mambo/styles.css');

// Render.
$renderer = $PAGE->get_renderer('block_mambo');

// Get a widget.
$widget = $DB->get_record('mambo_widget' , array('id' => $widgetid));

// Check if need for any special actions.

switch($action) {
    case 'delete':
        if ($widget) {
            $DB->delete_records('mambo_widget' , array('id' => $widget->id));
            redirect($PAGE->url);
        }
        break;
}

$form = new Addwidget_form($PAGE->url, array('widget' => $widget));

if ($widget) {
    $form->set_data((array) $widget);
}

if (($data = $form->get_data()) != false) {

    $obj = new stdClass();
    $obj->name  = $data->name;
    $obj->widget  = preg_replace('/\Mambo.+?\)/', '', $data->widget); // A. @TODO: remove junk. for us should look like this.

    if ($widget) {
        // Update widget.
        $obj->id = $widget->id;
        $DB->update_record('mambo_widget' , $obj);
    } else {
        // New widget.
        $DB->insert_record('mambo_widget' , $obj);
    }

    redirect($PAGE->url);
}

echo $OUTPUT->header();
echo $renderer->list_all_widgets();

echo '<hr/>';

$newbtn = clone $PAGE->url;
$newbtn->remove_params(array('widgetid'));
echo html_writer::link($newbtn , get_string('new' , 'block_mambo') , array('class' => 'btn'));

echo $form->render();
// Sending moodle footer.
echo $OUTPUT->footer();
