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
 * behaviours mambo
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Virgil Ashruf
 **/
class transactions extends mambo {
    /**
     * function post_transaction
     *
     * @param $userid
     * @param $pointId
     * @param $points
     * @param $reason
     *
     * @return boolean
     **/
    static public function post_transaction($userid = 0, $pointId = '', $points = 0, $reason = '', $description = false, $imageUrl = false) {
        global $CFG;
        // Load mambo.
        self::load_mambo_sdk();

        // Prepare the request data used to register the transaction.
        $data = new \ActivityRequestData();
        $data->setUuid( $userid ); // Required.

        // Prepare the attributes
        $attrs = new \ActivityPointAttrs();
        $attrs->setAction( "increment" ); // Required.
        $attrs->setReason( $reason );

        // Prepare the point.
        if(is_array($pointId)) {
            foreach($pointId as $id => $points) {
                $point = new \SimplePoint();
                $point->setPointId( $id ); // Required.
                $point->setPoints( $points ); // Required.
                $attrs->addPoints( $point ); // Required.
            }
        } else {
            $point = new \SimplePoint();
            $point->setPointId( $pointId ); // Required.
            $point->setPoints( $points ); // Required.
            $attrs->addPoints( $point ); // Required.
        }

        // Create a new Manual transaction.
        $data->setAttrs( $attrs ); // Required.

        $content = new \Content();
        $content->setTitle($reason); // Required
        if($description) {
            $content->setDescription($description);
        }
        if($imageUrl) {
            $content->setImageUrl($imageUrl);
        }
        $content->setUrl($CFG->wwwroot);

        $data->setContent( $content );

        // Register a new transaction.
        $transaction = \MamboActivitiesService::create( self::$config->site, $data );
        
        if (!isset($transaction->error)) {
            return true;
        }

        return false;
    }
}
