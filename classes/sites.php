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
 * sites wrapper
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file: sites.php
 * @since 25-3-2015
 * @encoding: UTF8
 *
 * @package: block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

namespace block_mambo;

defined('MOODLE_INTERNAL') || die();

class sites extends mambo {

    /**
     * Get all sites
     * @return array
     */
    static public function get_all() {

        // load mambo
        self::load_mambo_sdk();

        $response = \MamboSitesService::getSites();
        if(empty($response->error))
        {
            return $response;
        }
        return false;
    }
}