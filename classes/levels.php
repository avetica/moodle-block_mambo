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
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

/**
 * points mambo
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
class levels extends mambo {
    
    /**
     * get levels from mambo
     * @return object|bool
     */
    static public function get() {
        // load mambo
        self::load_mambo_sdk();
        
        // Get the list of levels for the site specified
        $response = \MamboRewardsService::getLevels( self::$config->site );
        
         if(empty($response->error)) {
             return $response;
         }

         return FALSE;
    }
    /**
     * get user levels from mambo
     * @param int $userid
     * @return object|bool
     */
     static public function get_user_levels($userid) {
         // load mambo
         self::load_mambo_sdk();
         
         $response = \MamboUsersService::getLevels(self::$config->site, $userid);
         
         if(empty($response->error)) {
             return $response;
         }

         return FALSE;
     }
}