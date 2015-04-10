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
 * Mambo block contains link to activities mapping
 * Can only be added inside a course page
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

class block_mambo extends block_base {

    /**
     * Init.
     *
     * @return void
     */
    function init() {
        $this->title = get_string('pluginname', 'block_mambo');
    }

    /**
     * Are you going to allow multiple instances of each block?
     * If yes, then it is assumed that the block WILL USE per-instance configuration
     * @return boolean
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Subclasses should override this and return true if the
     * subclass block has a settings.php file.
     *
     * @return boolean
     */
    function has_config() {
        return true;
    }

    /**
     * Applicable formats.
     *
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true, 'mod' => true, 'tag' => true);
    }

    function instance_allow_config() {
        return true;
    }

    /**
     * Specialization.
     *
     * Happens right after the initialisation is complete.
     *
     * @return void
     */
    function specialization() {

        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_mambo');
        } else {
            $this->title = $this->config->title;
        }
    }

    function get_content() {
        global $CFG, $COURSE;

        require_once $CFG->libdir . '/formslib.php';
        require_once  'locallib.php';

        if ($this->content !== null) {
            return $this->content;
        }

        if ((!isloggedin() || isguestuser())) {
            $this->content = new stdClass();
            $this->content->text = '';

            return $this->content;
        }

        $blockcontext = context_block::instance($this->instance->id , MUST_EXIST);

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';


        // show mapping button for manager usage
        if( has_capability('block/mambo:view', $blockcontext)){
            $this->content->footer .= html_writer::link(new moodle_url('/blocks/mambo/view.php' , array('blockid'=> $this->instance->id , 'courseid' =>  $COURSE->id)), get_string('btn:setup', 'block_mambo'));
        }
        // check if this block has a widget
        if(($widget = block_mambo_load_widget($this->config->widget , $this->instance->id)) !== '')
        {
            block_mambo_add_widget_init();
            $this->content->text .= $widget;
        }

        return $this->content;
    }

}