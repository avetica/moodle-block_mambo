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
 * @file      : activities.php
 * @since     30-3-2015
 * @encoding  : UTF8
 *
 * @package   : block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class activities {


    /**
     * check if completion is turned on
     *
     * @param stdClass $course Moodle course object.
     *
     * @return bool
     */
    public function has_completion($course) {
        global $CFG;

        return ($CFG->enablecompletion) ? true : false;
    }

    /**
     * get list of activities that are available
     *
     * @param stdClass $course Moodle course object.
     * @param mixed $points    the points from mambo
     *
     * @return false|array
     * @throws \moodle_exception
     */
    public function get_mapping_activities($course, $points) {
        global $DB;

        // get already linked items
        $rs = $DB->get_recordset('mambo_point', array('courseid' => $course->id));
        foreach ($rs as $record) {
            if (isset($points[$record->mamboid])) {
                if (empty($points[$record->mamboid]->items)) {
                    $points[$record->mamboid]->items = array();
                }
                $points[$record->mamboid]->items[$record->id] = $record;
            }
        }
        $rs->close();

        $array = array('points' => $points, 'activities' => array());
        $completioninfo = new \completion_info($course);
        $activities = $completioninfo->get_activities();

        foreach ($activities as $activity) {

            $obj = new \stdClass();
            $obj->displayname = shorten_text($activity->name);
            $array['activities'][$activity->id] = $obj;
        }

        return $array;
    }

    /**
     * get a mambo mapping to a coursemodule
     *
     * @param int $coursemoduleid
     *
     * @global moodle_database $DB
     * @return object|false
     */
    public function get_activity_maps($coursemoduleid = 0) {
        global $DB;

        return $DB->get_records('mambo_point', array('coursemoduleid' => $coursemoduleid));
    }

    /**
     * add activity mapping to the db
     *
     * @param int $coursemoduleid
     * @param string $mamboid
     *
     * @global moodle_database $DB
     * @return bool
     */
    public function add_activity_map($coursemoduleid = 0, $mamboid = '', $courseid = 0) {
        global $DB;

        $obj = new \stdClass();
        $obj->coursemoduleid = $coursemoduleid;
        $obj->mamboid = $mamboid;
        $obj->courseid = $courseid;

        // make sure not already exists
        $row = $DB->get_record('mambo_point', (array)$obj);
        if (!$row) {
            $obj->addedon = time();
            $DB->insert_record('mambo_point', $obj);

            return true;
        }

        return false;
    }

    /**
     * delete activity mapping
     *
     * @param int $coursemoduleid
     *
     * @global moodle_database $DB
     * @return void
     */
    public function delete_activity_map($coursemoduleid = 0) {
        global $DB;
        $DB->delete_records('mambo_point', array('coursemoduleid' => $coursemoduleid));
    }

    /**
     * send points to a user
     *
     * @param int $userid
     * @param int $completionstate
     * @param bool|object $record
     *
     * @return bool false if something goes wrong or already action executed
     * @global moodle_database $DB
     */
    public function send_points($userid = 0, $completionstate = COMPLETION_UNKNOWN, $record = false) {

        global $DB;

        if (!$record) {
            return false;
        }

        // check if we already have a record
        $pointuser = $DB->get_record('mambo_point_user', array(
            'userid' => $userid,
            'coursemoduleid' => $record->coursemoduleid
        ));
        if ($pointuser) {
            if ($pointuser->send == 1) {
                return false;
            }
        }

        // sending this to mambo
        $response = \block_mambo\points::add_points($userid, $record->mamboid);

        $obj = new \stdClass();
        $obj->userid = $userid;
        $obj->mamboid = $record->mamboid;
        $obj->coursemoduleid = $record->coursemoduleid;
        $obj->completionstate = $completionstate;
        $obj->sendon = time();
        $obj->send = (empty($response->error)) ? 1 : 0;

        if (!$pointuser) {
            $DB->insert_record('mambo_point_user', $obj);
        } else {
            $obj->id = $pointuser->id;
            $DB-update_record('mambo_point_user', $obj);
        }
        echo '<pre>';print_r($response);echo '</pre>';die(__LINE__.' '.__FILE__);
    }
}