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
 * helper
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class helper {

    /**
     * Validation file used to ensure that all the dependencies required in order to
     * use the Mambo PHP SDK are available.
     *
     * @return string
     */
    public static function compatibillitycheck() {
        $string = '';

        $php_ok = (function_exists('version_compare') && version_compare(phpversion(), '5.3.0', '>='));
        $json_ok = (extension_loaded('json') && function_exists('json_encode') && function_exists('json_decode'));
        $curl_ok = false;
        if (function_exists('curl_version')) {
            $curl_version = curl_version();
            $curl_ok = (function_exists('curl_exec') && in_array('https', $curl_version['protocols'], true));
        }

        // Let the user know the results of the compatibility check.
        $string .= '<hr/>Mambo PHP Environment Compatibility Test' . PHP_EOL;
        $string .= PHP_EOL;
        $string .= 'PHP 5.3 or newer............ ' . ($php_ok ? ('Pass ' . phpversion()) : 'Fail') . PHP_EOL;
        $string .= 'cURL with SSL............... ' . ($curl_ok ? ('Pass ' . $curl_version['version'] . ' (' . $curl_version['ssl_version'] . ')') : 'Fail ' . $curl_version['version'] . (in_array('https', $curl_version['protocols'], true) ? ' (with ' . $curl_version['ssl_version'] . ')' : ' (without SSL)')) . PHP_EOL;
        $string .= 'JSON........................ ' . ($json_ok ? 'Pass' : 'Fail') . PHP_EOL;
        $string .= PHP_EOL;

        // Overall success or failure message.
        if ($php_ok && $curl_ok && $json_ok) {
            $string .= 'Your environment meets the minimum requirements for using the Mambo SDK for PHP' . PHP_EOL;
        } else {
            $string .= 'Your PHP environment does not support the minimum requirements for the Mambo SDK for PHP.' . PHP_EOL;

            if (!$php_ok) {
                $string .= '* PHP: You are running an unsupported version of PHP.' . PHP_EOL . PHP_EOL;
            }
            if (!$curl_ok) {
                $string .= '* cURL: cURL support is not available. Without cURL, the SDK cannot connect to Mambo\'s API.' . PHP_EOL . PHP_EOL;
            }
            if (!$json_ok) {
                $string .= '* JSON: JSON support is not available. Mambo returns JSON for all of its services.' . PHP_EOL . PHP_EOL;
            }
        }

        return nl2br($string);
    }
}
