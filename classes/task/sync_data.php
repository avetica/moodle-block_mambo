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
 * sync_data behind the scene
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo\task;
use block_mambo;

class sync_data extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('task', 'block_mambo');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;
        mtrace(__CLASS__);
        $config = get_config('block_mambo');

        if(empty($config->site))
        {
            // there is no valid setup
            throw new Exception('Mambo Not Setup correctly - Missing site');
        }

        // check if we need to sync user data
        if(!empty($config->users_synced))
        {
            // get all users no deleted
            $users = $DB->get_records('user' , array('deleted' => 0));

            foreach ($users as $user) {
                mtrace('Add User to MamboIO: ' . fullname($user));
                $response = \block_mambo\user::set($user);
                echo print_r($response);
            }

            set_config('users_synced' , time() , 'block_mambo');
        }

        // failed adding points
        $rs = $DB->get_recordset('mambo_behaviour_user', array('send' => 0));
        foreach ($rs as $record) {
           $response =  \block_mambo\behaviours::add_event($record->userid, $record->verb);
            echo print_r($response);
        }
        $rs->close();
        mtrace(' ');
        return true;
    }
}