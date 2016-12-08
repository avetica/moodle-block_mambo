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
                $metadata['event'] = 'course_module_completion_updated';
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

    /**
     * Triggered from user_graded event
     * event_user_graded
     *
     * @param \core\event\user_graded $event
     *
     * @return void
     */
    public static function event_user_graded(\core\event\user_graded $event) {
        global $DB;
        $userid = $event->relateduserid;
        // Get the course module using the grade item.
        $giid = $event->other['itemid'];
        if (!$gitem = \grade_item::fetch(array('id' => $giid))) {
            // There is no grade item.
            return;
        }
        if($gitem->itemmodule == NULL) {
            // The grade item is not a module.
            return;
        }
        $module = $DB->get_record('modules', array('name' => $gitem->itemmodule));
        $coursemodule = $DB->get_record('course_modules', array('instance' => $gitem->iteminstance,
                                                                'course' => $gitem->courseid,
                                                                'module' => $module->id));
        // We need to check if need to take a action.
        $activities = new \block_mambo\activities();
        if (($links = $activities->get_activity_maps($coursemodule->id)) != false) {
            // Get the completion state
            $completion = $DB->get_record('course_modules_completion', array('coursemoduleid' => $coursemodule->id));

            // Get metadata for activity.
            $metadata = array();
            $metadata = $activities->get_activity_metadata($coursemodule->id, $userid, $completion->completionstate);
            $metadata['event'] = 'user_graded';
            \block_mambo\mambo::load_mambo_sdk();
            $content = new \Content();
            $content->setTitle($activities->get_activity_title($coursemodule->id));
            $content->setUrl($activities->get_activity_url($coursemodule->id));
            foreach ($links as $link) {
                $activities->send_event($userid, $completion->completionstate, $link, $metadata, $content);
            }
        }
    }
    
    public static function badge_awarded(\core\event\badge_awarded $event) {
        // TODO: add code to process the awarded badge and notify the user
    }
}

