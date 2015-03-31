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
 * mambo loader
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class mambo {

    /**
     * plugin config values
     *
     * @var array
     */
    static $config = array();

    /**
     * Load Mambo SDK
     *
     * @throws \Exception
     * @throws \dml_exception
     */
    public static function load_mambo_sdk() {

        if (!empty(self::$config)) {
            return;
        }

        // Import the library files
        require_once(dirname(__FILE__) . '/../libs/Mambo.php');

        self::$config = get_config('block_mambo');

        // check if set else triggers warnings on fresh environment
        $settingsNeeded = array('apikey_public', 'apikey_private', 'api_url');
        foreach ($settingsNeeded as $setting) {
            if (empty(self::$config->$setting)) {
                // reset
                self::$config = array();
                throw new Exception('Mambo missing setting:' . $setting);
            }
        }

        // Initialise the clients credentials and end point URL, this only needs to be done once
        \MamboClient::setCredentials(self::$config->apikey_public, self::$config->apikey_private);
        \MamboClient::setEndPointBaseUrl(self::$config->api_url);

        \MamboClient::$debug = !empty(self::$config->debug) ? true : false;
    }
}