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
 * @author    Luuk Verhoeven
 **/
class behaviours extends mambo {

    /**
     * getting all behaviours
     * @return object|bool
     */
    static public function get_all() {

        // Load mambo.
        self::load_mambo_sdk();

        $response = \MamboBehavioursService::getBehaviours(self::$config->site);

        if (empty($response->error)) {

            $array = array();
            foreach ($response as $item) {
                if ($item->attrs->type == 'simple') {
                    $array[$item->verb] = $item;
                }
            }

            return $array;
        }

        return false;
    }

    static public function get($tag = null) {
        // Load mambo.
        self::load_mambo_sdk();

        if ($tag === null) {
            $response = $this->get_all();
        } else {
            $response = \MamboBehavioursService::getBehaviours(self::$config->site, $tag);
        }
        if (empty($response->error)) {
            return $response;
        }

        return false;
    }

    static public function get_by_id($id = null) {
        // Load mambo.
        self::load_mambo_sdk();

        if ($id === null) {
            $response = $this->get_all();
        } else {
            $response = \MamboBehavioursService::get($id);
        }

        if (empty($response->error)) {
            return $response;
        }

        return false;
    }

    /**
     * add_event to a user
     * using the verb that is set in mambo
     *
     * @param int $userid
     * @param string $verb
     *
     * @return bool|string $response
     */
    static public function add_event($userid = 0, $verb = '', $metadata = array(), $content = '') {

        global $DB, $CFG;

        // Load mambo.
        self::load_mambo_sdk();

        $data = new \ActivityRequestData();
        $data->setUuid($userid); // Required.
        $data->setUrl($CFG->wwwroot); // Required.

        // This needs to be in a ActivityBehaviourAttrsData.
        $attributes = new \ActivityBehaviourAttrs();
        $attributes->setVerb($verb); // Required.
        $attributes->setMetadata($metadata);

        $data->setAttrs($attributes);

        if (is_a($content, 'Content')) {
            $data->setContent($content);
        }

        $response = \MamboActivitiesService::create(self::$config->site, $data);

        // Retry if user didn't exists first.
        if (!empty($response->error->type) && $response->error->type == 'UserNotFoundException') {
            $user = $DB->get_record('user', array('id' => $userid));
            $response = \block_mambo\user::set($user);
            if ($response) {
                return self::add_event($userid, $verb, $metadata);
            }
        }

        return $response;
    }
}
