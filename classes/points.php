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
class points extends mambo {

    /**
     * get all points from mambo (optionally by tag)
     * @param array $tags
     * @return object|bool
     */
     static public function get_all($tags = false) {

        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboPointsService::getPoints(self::$config->site);
       
        if (empty($response->error)) {
            $array = array();
            if($tags){
                foreach($tags as $tag){                
                    foreach($response as $result) {
                        // If the points have a tag.
                        if (count($result->tags) > 0) {
                            // Then see if any of the returned tags match our filter.
                            foreach($result->tags as $mambotag) {                            
                                if ($mambotag->tag == $tag) {
                                    // And stock our array with the object.
                                    $array[$result->id] = $result;
                                }
                            }
                        }
                    }
                }
            } else {
                // We dont have $tags, so we just stock our array :-).
                $array[$result->id] = $result;
            }
            return $array;
        }
        return false;
     }

     static public function get($pointid) {

        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboPointsService::get($pointid);

        if (empty($response->error)) {
            return $response;
        }

        return false;
     }
}
