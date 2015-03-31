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
 * @file      : points.php
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

class points extends mambo {

    /**
     * Get all points available for current site
     *
     * @return array
     */
    static public function get_all() {

        // load mambo
        self::load_mambo_sdk();

        $response = \MamboPointsService::getPoints(self::$config->site);
        if (empty($response->error)) {

            $array = array();
            foreach ($response as $item) {
                $array[$item->id] = $item;
            }

            return $array;
        }

        return false;
    }

    /**
     * add_points to a user
     *
     * @param int $userid
     * @param string $mambopointid
     * @param int $pointsrewarded
     *
     * @return $response
     */
    static public function add_points($userid = 0, $mambopointid = '', $pointsrewarded = 1) {

        global $DB;

        // load mambo
        self::load_mambo_sdk();

        $data = new \TransactionRequestData();
        $data->setUUID($userid);

        $point = new \SimplePoint();
        $point->setPointId($mambopointid);
        $point->setPoints($pointsrewarded);

        $data->setPoints($point);

        $response = \MamboTransactionsService::create(self::$config->site, $data);

        // retry if we didn't exists first
        if (!empty($response->error->type) && $response->error->type == 'UserNotFoundException') {
            $user = $DB->get_record('user', array('id' => $userid));
            $response = \block_mambo\user::set($user);
            if ($response) {
                return self::add_points($userid, $mambopointid, $pointsrewarded);
            }
        }
        return $response;
    }

}