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
 * widget form
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   : block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden!');
}
global $CFG;
require_once($CFG->libdir . '/formslib.php');

class Addwidget_form extends moodleform {
    protected function definition() {
        global $DB;
        $mform = &$this->_form;
        $widget = !empty($this->_customdata['widget']) ? $this->_customdata['widget'] : false;

        if ($widget) {
            $mform->addElement('header', 'header1', get_string('widget:edit' , 'block_mambo'));
        } else {
            $mform->addElement('header', 'header1', get_string('widget:new' , 'block_mambo'));
        }

        $mform->addElement('text', 'name', get_string('widget:name', 'block_mambo'), array('size' => '48'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        $mform->addElement('textarea', 'widget', get_string('widget_content', 'block_mambo'),
                           array('style' => 'width:100%;height:400px'));

        $this->add_action_buttons(false, get_string('save' , 'block_mambo'));
    }

    /**
     * validate if its the correct data
     *
     * @param array $data
     * @param array $files
     *
     * @return array
     * @throws coding_exception
     */
    protected function validation($data, $files) {

        $errors = parent::validation($data, $files);
        if (!empty($data['config_widget']) && !stristr($data['config_widget'] , 'mambo_widget_' . $this->block->instance->id)) {
            $errors['config_widget'] = get_string('error:notfounddivid', 'block_mambo');
        }

        return $errors;
    }
}
