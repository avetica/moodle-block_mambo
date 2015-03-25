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
 *
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file      : user.php
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

class user extends mambo {

    /**
     * set user object to mambo if not exist will insert a new user object
     *
     * @param bool|object $userobject
     */
    static public function set($userobject = false) {

        if (!$userobject) {
            return;
        }

        // load mambo
        self::load_mambo_sdk();

        $return = \MamboUsersService::getById($userobject->id);

        if($return === NULL)
        {
            // there is no user found with this id

        }

        var_export($return);
        print_r($return);
        echo '</pre>';
        die(__LINE__ . ' ' . __FILE__);
    }
}