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
 * Privacy Subsystem implementation for block_mambo.
 *
 * @package    block_mambo
 * @copyright  2018 Bastiaan Bliek <b.bliek@avetica.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



namespace block_mambo\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\context;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\writer;

defined('MOODLE_INTERNAL') || die();

class provider implements \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider {

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int $userid The user to search.
     *
     * @return  contextlist   $contextlist  The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid) : contextlist {

        $contextlist = new contextlist();

        // The mambo data is associated at the user context level, so retrieve the user's context id.
        $sql = "SELECT c.id
                  FROM {mambo_behaviour_user} m
                  JOIN {context} c ON c.instanceid = m.userid AND c.contextlevel = :contextuser
                 WHERE m.userid = :userid
              GROUP BY c.id";

        $contextlist->add_from_sql($sql, [
            'contextuser' => CONTEXT_USER,
            'userid' => $userid,
        ]);

        return $contextlist;
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist $contextlist The approved contexts to export information for.
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        // If the user has mambo data, then only the User context should be present so get the first context.
        $contexts = $contextlist->get_contexts();
        if (count($contexts) == 0) {
            return;
        }
        $context = reset($contexts);

        // Sanity check that context is at the User context level, then get the userid.
        if ($context->contextlevel !== CONTEXT_USER) {
            return;
        }
        $userid = $context->instanceid;


        $sql = "SELECT
                        m.id as id,
                        m.userid as userid,
                        m.coursemoduleid as coursemoduleid,
                        m.verb as verb,
                        m.completionstate as completionstate,
                        m.send as send,
                        m.sendon as sendon,
                        m.metadata as metadata
              FROM {mambo_behaviour_user} as m
              WHERE m.userid = :userid";

        // Get all voucher of given user.
        $user_mambo_infos = $DB->get_records_sql($sql, [
            'userid' => $userid,
        ]);

        foreach($user_mambo_infos as &$user_mambo_info){
            // Make sure its readable.
            $user_mambo_info->completionstate =  \core_privacy\local\request\transform::yesno($user_mambo_info->completionstate);
            $user_mambo_info->send =  \core_privacy\local\request\transform::yesno($user_mambo_info->send);
            $user_mambo_info->sendon =  \core_privacy\local\request\transform::datetime($user_mambo_info->sendon);
        }


        writer::with_context($context)
            ->export_data([
                get_string('pluginname', 'block_mambo'),
            ], (object)[
                'mambo' => $user_mambo_infos,
            ]);
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context The specific context to delete data for.
     *
     * @throws \dml_exception
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        // Sanity check that context is at the User context level, then get the userid.
        if ($context->contextlevel !== CONTEXT_USER) {
            return;
        }
        $userid = $context->instanceid;

        $DB->delete_records('mambo_behaviour_user', ['userid' => $userid]);
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist $contextlist The approved contexts and user information to delete information for.
     *
     * @throws \dml_exception
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
        // If the user has block_community data, then only the User context should be present so get the first context.
        $contexts = $contextlist->get_contexts();
        if (count($contexts) == 0) {
            return;
        }
        $context = reset($contexts);

        // Sanity check that context is at the User context level, then get the userid.
        if ($context->contextlevel !== CONTEXT_USER) {
            return;
        }
        $userid = $context->instanceid;

        $DB->delete_records('mambo_behaviour_user', ['userid' => $userid]);
    }

    /**
     * Returns meta data about this system.
     *
     * @param   collection $collection The initialised collection to add items to.
     *
     * @return  collection     A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection {

        $collection->add_external_location_link(
        'mambo_external',
            [
                'ProfileUrl' => 'privacy:metadata:mambo:ProfileUrl',
                'PictureUrl' => 'privacy:metadata:mambo:PictureUrl',
                'Ismember' => 'privacy:metadata:mambo:Ismember',
                'Email' => 'privacy:metadata:mambo:Email',
                'FirstName' => 'privacy:metadata:mambo:FirstName',
                'LastName' => 'privacy:metadata:mambo:LastName',
                'DisplayName' => 'privacy:metadata:mambo:DisplayName',
                'Birthday' => 'privacy:metadata:mambo:Birthday',
                'Gender' => 'privacy:metadata:mambo:Gender',
            ],
            'privacy:metadata:mambo:external'
        );

        $collection->add_database_table(
            'mambo',
            [
                'userid' => 'privacy:metadata:mambo:userid',
                'coursemoduleid' => 'privacy:metadata:mambo:coursemoduleid',
                'verb' => 'privacy:metadata:mambo:verb',
                'completionstate' => 'privacy:metadata:mambo:completionstate',
                'send' => 'privacy:metadata:mambo:send',
                'sendon' => 'privacy:metadata:mambo:sendon',
                'metadata' => 'privacy:metadata:mambo:metadata',
            ],
            'privacy:metadata:mambo'
        );

        return $collection;
    }
}
