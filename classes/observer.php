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
 * @file      : events.php
 * @since     25-3-2015
 * @encoding  : UTF8
 *
 * @package   : block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class observer {


    /**
     * Triggered via user_created event
     *
     * @param \core\event\user_created $event
     * @return void
     */
    public static function user_created(\core\event\user_created $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {
            // we have a new user record, forwarding it to mambo.io
            \block_mambo\user::set($record);
        }
    }

    /**
     * Triggered via user_deleted event
     *
     * @param \core\event\user_deleted $event
     * @return void
     */
    public static function user_deleted(\core\event\user_deleted $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {

            // load sdk with credentials
            // we have a new user record, forwarding it to mambo.io
            \block_mambo\user::set($record);
        }
    }

    /**
     * Triggered via user_updated event
     *
     * @param \core\event\user_updated $event
     * @return void
     */
    public static function user_updated(\core\event\user_updated $event) {

        $record = $event->get_record_snapshot('user', $event->objectid);

        if (!empty($record)) {

            // load sdk with credentials
            // we have a new user record, forwarding it to mambo.io
            \block_mambo\user::set($record);
        }
    }

}

