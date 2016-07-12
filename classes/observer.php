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
 * events that also should be forwarded to mambo
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class observer {

    /**
     * Triggered from user_created event
     *
     * @param \core\event\user_created $event
     *
     * @return void
     */
    public static function user_created(\core\event\user_created $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {
            // We have a new user record, forwarding it to mambo.io.
            \block_mambo\user::set($record);
        }
    }

    /**
     * Triggered from user_deleted event
     *
     * @param \core\event\user_deleted $event
     *
     * @return void
     */
    public static function user_deleted(\core\event\user_deleted $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {

            // Load sdk with credentials.
            // We need to remove this user from mambo.
            \block_mambo\user::delete($record);
        }
    }

    /**
     * Triggered from user_updated event
     *
     * @param \core\event\user_updated $event
     *
     * @return void
     */
    public static function user_updated(\core\event\user_updated $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {

            // Load sdk with credentials.
            // We have a update for a user record, forwarding it to mambo.io.
            \block_mambo\user::set($record);
        }
    }

    /**
     * Triggered from course_module_completion_updated event
     *
     * @param \core\event\course_module_completion_updated $event
     *
     * @return void
     */
    public static function course_module_completion_updated(\core\event\course_module_completion_updated $event) {

        $eventdata = $event->get_record_snapshot('course_modules_completion', $event->objectid);
        $userid = $event->relateduserid;
        $states = array(COMPLETION_COMPLETE, COMPLETION_COMPLETE_PASS, COMPLETION_COMPLETE_FAIL);

        if (in_array($eventdata->completionstate, $states)) {
            // We need to check if need to take a action.
            $activities = new \block_mambo\activities();
            if (($links = $activities->get_activity_maps($eventdata->coursemoduleid)) != false) {
                // Get metadata for activity.
                $metadata = array();
                $metadata = $activities->get_activity_metadata($eventdata->coursemoduleid, $userid, $eventdata->completionstate);
                \block_mambo\mambo::load_mambo_sdk();
                $content = new \Content();
                $content->setTitle($activities->get_activity_title($eventdata->coursemoduleid));
                $content->setUrl($activities->get_activity_url($eventdata->coursemoduleid));
                foreach ($links as $link) {
                    $activities->send_event($userid, $eventdata->completionstate, $link, $metadata, $content);
                }
            }
        }
    }

    /**
     * Triggered from course_module_deleted event
     *
     * @param \core\event\course_module_deleted $event
     *
     * @return void
     */
    public static function course_module_deleted(\core\event\course_module_deleted $event) {
        global $DB;
        // Remove linked items.
        $DB->delete_records('mambo_behaviour', array('coursemoduleid' => $event->objectid));
        $DB->delete_records('mambo_behaviour_user', array('coursemoduleid' => $event->objectid));
    }

}

