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
 * get the activities from a course
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file: activities.php
 * @since 30-3-2015
 * @encoding: UTF8
 *
 * @package: block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class activities{


    public function __construct()
    {

    }


    /**
     * check if completion is turned on
     * @param stdClass $course Moodle course object.
     * @return bool
     */
    public function hasCompletion($course)
    {
        global $CFG;

        return ($CFG->enablecompletion) ? true : false;
    }

    /**
     * get list of activities that are available
     *
     * @param stdClass $course Moodle course object.
     * @param mixed $points the points from mambo
     *
     * @return false|array
     * @throws \moodle_exception
     */
    public function getMapping($course , $points)
    {
        global $DB;

        $array = array('points' => $points , 'activities' => array());
        $completioninfo = new \completion_info($course);
        $activities = $completioninfo->get_activities();

        foreach($activities as $activity) {

            $obj = new \stdClass();
            $obj->displayname = shorten_text($activity->name);
            $array['activities'][$activity->id] = $obj;
        }

        return $array;
    }

}