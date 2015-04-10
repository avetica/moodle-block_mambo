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
 *  Form for editing mambo block instances.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   : block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
class block_mambo_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Fields for editing HTML block title and contents.
        $blockcontext = context_block::instance($this->block->instance->id, MUST_EXIST);
        if (has_capability('block/mambo:addwidget', $blockcontext)) {
            $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

            $mform->addElement('text', 'config_title', get_string('configtitle', 'block_html'));
            $mform->setType('config_title', PARAM_TEXT);

            $templates = array(
                '' => get_string('select', 'block_mambo'),
                'header' => 'header',
                'profile' => 'profile',
                'earnPoints' => 'earnPoints',
                'leaderboard' => 'leaderboard',
                'activities' => 'activities',
                'toaster' => 'toaster',
            );

            $mform->addElement('select', 'config_template', get_string('template', 'block_mambo'), $templates);

            if (!empty($this->block->config->widget)) {

                // template is loaded we can show the editor
                $mform->addElement('textarea', 'config_widget', get_string('widget_content', 'block_mambo'), array('style' => 'width:100%;height:400px'));
                $mform->disabledIf('config_widget', 'config_template', 'neq', $this->block->config->template);
                //add a helper
                $obj = new stdClass();
                $obj->id = $this->block->instance->id;
                $mform->addElement('static', 'widget_static', '', get_string('template_helper', 'block_mambo', $obj));
            }
            else{
                $mform->addElement('hidden', 'config_widget');
            }

            $mform->setType('config_widget', PARAM_RAW);
        }
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
    function validation($data, $files) {

        $errors = parent::validation($data, $files);
        if (!empty($data['config_widget']) && !stristr($data['config_widget'] , 'mambo_widget_' . $this->block->instance->id)) {
            $errors['config_widget'] = get_string('error:notfounddivid', 'block_mambo');
        }

        return $errors;
    }

    /**
     * add the code on first save action
     * @return object
     */
    function get_data()
    {
        $data = parent::get_data();
        if(!empty($data))
        {
            if( (!empty($data->config_template) && empty($this->block->config->template)) || (empty($data->config_widget) && !empty($data->config_template)) || $data->config_template != $this->block->config->template)
            {
                // we need to update the widget code
                $templateKey = $data->config_template;
                // we need to load the correct template

                include_once 'widgets_templates.php';
                $data->config_widget = !empty($templates[$templateKey]) ? str_replace('##BLOCKID##', $this->block->instance->id, $templates[$templateKey]) : '';
            }
        }
        return $data;
    }
}