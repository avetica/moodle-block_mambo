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
     * update user, if not exist will insert a new user
     *
     * @param bool|object $userobject
     *
     * @return bool
     */
    static public function set($user = false) {

        if (!$user) {
            return false;
        }

        // load mambo
        self::load_mambo_sdk();

        // API docs
        // http://api.mambo.io/#docs/POST__v1_site_users/top

        $response = \MamboUsersService::get(self::$config->site, $user->id);

        if (!empty($response->error)) {
            // there is no user found with this id
            return self::create($user);
        } elseif (!empty($response->id)) {
            return self::update($user);
        }

        // strange we should end here
        return false;
    }

    /**
     * remove a user
     * @param $user
     *
     * @return bool
     */
    static public function delete($user)
    {
        if (!$user) {
            return false;
        }

        // load mambo
        self::load_mambo_sdk();

        $response = \MamboUsersService::delete(self::$config->site, $user->id);

        if (!empty($response->error)) {
            //@todo log errors
            return false;
        }

        return true;
    }

    /**
     * create a new user
     *
     * @param object $user
     *
     * @return bool
     */
    static private function create($user) {

        global $CFG , $PAGE;

        $data = new \UserRequestData();
        $data->setUuid($user->id); // Required
        $user_picture = new \user_picture($user);
        $user_picture->size = 1;
        $data->setPictureUrl($user_picture->get_url($PAGE)->out(false));
        $data->setProfileUrl($CFG->wwwroot . '/user/profile.php?id=' . $user->id);
        $data->setIsMember(true);

        // Prepare the user details
        $details = new \UserDetails();
        $details->setEmail($user->email); // Required
        $details->setFirstName($user->firstname); // Required
        $details->setLastName($user->lastname); // Required
        $details->setDisplayName(fullname($user));

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
     * @param object $user
     *
     * @return bool
     */
    static private function update($user) {

        global $CFG, $PAGE;

        // Prepare the request data used to update the user
        $data = new \UserRequestData();
        $user_picture = new \user_picture($user);
        $user_picture->size = 1;
        $data->setPictureUrl($user_picture->get_url($PAGE)->out(false));
        $data->setProfileUrl($CFG->wwwroot . '/user/profile.php?id=' . $user->id);
        $data->setIsMember(true);

        $details = new \UserDetails();
        $details->setEmail($user->email); // Required
        $details->setFirstName($user->firstname); // Required
        $details->setLastName($user->lastname); // Required
        $details->setDisplayName(fullname($user));

        $data->setDetails($details);

        // Update the user
        $response = \MamboUsersService::update(self::$config->site, $user->id, $data);
        if (!empty($response->error)) {
            // @todo we don't return exceptions to users we log them instead
            // failed creating user
            return false;
        }

        return true;
    }
}