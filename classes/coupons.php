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
 * get the coupons
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class coupons {
    /**
     * getting all coupons
     * @return object|bool
     */
    static public function get_all() {
        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboCouponsService::getCoupons(self::$config->site);

        if (empty($response->error)) {
            // Provide array.
            return $response;
        }

        return false;
    }

    /**
     * getting all buyable coupons
     * @return object|bool
     */
    static public function get_all_buyable() {
        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboCouponsService::getBuyableCoupons(self::$config->site);

        if (empty($response->error)) {
            // Provide array.
            return $response;
        }

        return false;
    }

    /**
     * getting coupon
     * @return object|bool
     */
    static public function get_coupon($coupon) {
        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboCouponsService::get($coupon);

        if (empty($response->error)) {
            // Provide array.
            return $response;
        }

        return false;
    }

    // POST /v1/{site}/coupons/redeem.
    /**
     * getting all coupons
     * @return object|bool
     */
    static public function redeem($userid, $coupon) {
        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboCouponsService::redeem(self::$config->site, $userid, $coupon);

        if (empty($response->error)) {
            // Provide array.
            return $response;
        }

        return false;
    }
}
