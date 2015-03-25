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
 * user wrapper
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
     * set user if not exist will insert a new user
     *
     * @param bool|object $userobject
     *
     * @return bool
     */
    static public function set($userobject = false) {

        if (!$userobject) {
            return false;
        }

        // load mambo
        self::load_mambo_sdk();

        // API docs
        // http://api.mambo.io/#docs/POST__v1_site_users/top

        $response = \MamboUsersService::get(self::$config->site, $userobject->id);

        if (!empty($response->error)) {
            // there is no user found with this id
            return self::create($userobject);
        } elseif (!empty($response->id)) {
            return self::update($userobject);
        }

        // strange we should end here
        return false;
    }

    /**
     * create a new user
     *
     * @param object $userobject
     *
     * @return bool
     */
    static private function create($userobject) {

        global $CFG , $PAGE;

        $data = new \UserRequestData();
        $data->setUuid($userobject->id); // Required
        $user_picture = new \user_picture($userobject);
        $user_picture->size = 1;
        $data->setPictureUrl($user_picture->get_url($PAGE)->out(false));
        $data->setProfileUrl($CFG->wwwroot . '/user/profile.php?id=' . $userobject->id);
        $data->setIsMember(true);

        // Prepare the user details
        $details = new \UserDetails();
        $details->setEmail($userobject->email); // Required
        $details->setFirstName($userobject->firstname); // Required
        $details->setLastName($userobject->lastname); // Required
        $details->setDisplayName(fullname($userobject));

        // this doesn't exists in moodle by default
        $details->setBirthday("1970-01-01T00:00:00.094Z"); // Required - Please use the format indicated
        $details->setGender("U"); // Required - Valid genders: M / F / U (M = Male, F = Female, U = Unknown)

        $data->setDetails($details);

        $response = \MamboUsersService::create(self::$config->site, $data);
        if (!empty($response->error)) {
            // @todo we don't return exceptions to users we log them instead
            // failed creating user
            return false;
        }

        // successfully insert new user
        return true;
    }

    /**
     * update a existing user
     *
     * @param object $userobject
     *
     * @return bool
     */
    static private function update($userobject) {

        global $CFG, $PAGE;

        // Prepare the request data used to update the user
        $data = new \UserRequestData();
        $user_picture = new \user_picture($userobject);
        $user_picture->size = 1;
        $data->setPictureUrl($user_picture->get_url($PAGE)->out(false));
        $data->setProfileUrl($CFG->wwwroot . '/user/profile.php?id=' . $userobject->id);
        $data->setIsMember(true);

        $details = new \UserDetails();
        $details->setEmail($userobject->email); // Required
        $details->setFirstName($userobject->firstname); // Required
        $details->setLastName($userobject->lastname); // Required
        $details->setDisplayName(fullname($userobject));

        $data->setDetails($details);

        // Update the user
        $response = \MamboUsersService::update(self::$config->site, $userobject->id, $data);
        if (!empty($response->error)) {
            // @todo we don't return exceptions to users we log them instead
            // failed creating user
            return false;
        }

        return true;
    }
}