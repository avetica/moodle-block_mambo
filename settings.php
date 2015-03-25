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
 * settings and presets.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('block_mambo_settings', '', get_string('pluginname_desc', 'block_mambo')));
    $settings->add(new admin_setting_configtext('block_mambo/apikey_public', get_string('apikey_public', 'block_mambo'), '', '', PARAM_ALPHANUM));
    $settings->add(new admin_setting_configtext('block_mambo/apikey_private', get_string('apikey_private', 'block_mambo'), '', '', PARAM_ALPHANUM));
    $settings->add(new admin_setting_configtext('block_mambo/api_url', get_string('api_url', 'block_mambo'), '', 'https://api.mambo.io', PARAM_URL));

    $result = array('' => get_string('select_a_site' , 'block_mambo'));
    $sites = \block_mambo\sites::get_all();

    if(!empty($sites))
    {
        foreach($sites as $site)
        {
            echo '<pre>';print_r($site);echo '</pre>';die(__LINE__.' '.__FILE__);
        }
    }
    
    $settings->add(new admin_setting_configselect('block_mambo/site', get_string('sites', 'block_mambo'), '', '', $results));
    $settings->add(new admin_setting_heading('block_mambo_check', '', \block_mambo\helper::compatibillitycheck()));
}