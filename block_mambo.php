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
 * Mambo block contains link to course settings
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

class block_mambo extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_mambo');
    }

    function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return false;
    }

    function applicable_formats() {
        return array(
            'my' => true,
            'all' => true,
        );
    }

    function instance_allow_config() {
        return true;
    }

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

        if ($this->content !== null) {
            return $this->content;
        }

        $systemcontext = context_system::instance();
        if ((!isloggedin() || isguestuser() || !has_capability('block/mambo:view', $systemcontext))) {
            $this->content = new stdClass();
            $this->content->text = '';

            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '<div class="singlebutton">
    <form action="' . $CFG->wwwroot . '/blocks/mambo/view.php" method="get">
        <div>
            <input type="hidden" name="blockid" value="' . $this->instance->id . '"/>
            <input type="hidden" name="courseid" value="' . $COURSE->id . '"/>
            <input class="singlebutton" type="submit" value="' . get_string('btn:setup', 'block_mambo') . '"/>
        </div>
    </form>
</div>';
        $this->content->footer = '';

        return $this->content;
    }
}