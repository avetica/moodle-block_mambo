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
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class rewards extends mambo {
    static public function get($id) {
        // load mambo
        self::load_mambo_sdk();
        $response = \MamboRewardsService::get($id);
        if(empty($response->error)) {
            return $response;
        }
        return false;
    }
    /*
     * Get all Achievements
     */
    static public function get_achievements() {
        // load mambo
        self::load_mambo_sdk();
        $response = \MamboRewardsService::getAchievements(self::$config->site);
        if(empty($response->error)) {
            return $response;
        }
        return false;
    }

    static public function create_achievement($name, $message, $points = false, $behaviourid, $picture = false) {
        // load mambo
        self::load_mambo_sdk();

		// Prepare the request data used to register the reward
		$data = new \RewardRequestData();
		$data->setName($name); // Required
		$data->setActive( true ); // Required
		$data->setMessage($message);
        $data->setHideInWidgets( false );

		// Add the points to the achievement
        if($points) {
            foreach($points as $point) {
                $newpoint = new \ExpiringPoint();
                $newpoint->setPointId($point->id); // Required
                $newpoint->setPoints($point->count); // Required
                $data->addPoints( $newpoint ); // Required
            }
        }

		// Create a new Achievement reward
		$attrs = new \AchievementAttrs();
		$attrs->setBehaviourId($behaviourid); // Required
		$attrs->setTimes( 1 ); // Required
		$attrs->setExpiration( new \NeverExpiration() );
		$attrs->setCountLimit(1);
		$data->setAttrs( $attrs ); // Required

		// Register a new reward
		$reward = \MamboRewardsService::create(self::$config->site, $data );

		// Check if there are any errors
		if( !is_null( $reward->error ) )
		{
		// Oops, handle stuff that goes wrong
		}
        if($picture) {
            //  $image = realpath( 'test-classes/test.png' );
            $uploadimage = \MamboRewardsService::uploadImage($reward->id, $picture );
        }
        return $reward;
    }
}
