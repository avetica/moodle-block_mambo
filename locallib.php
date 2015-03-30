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
 * block based functions
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @file: locallib.php
 * @since 30-3-2015
 * @encoding: UTF8
 *
 * @package: block_mambo
 *
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die();

/**
 * load the module needed to make snapshots
 */
function block_mambo_add_javascript_module() {
    global $PAGE, $CFG, $USER;

    $jsmodule = array(
        'name' => 'block_mfavatar',
        'fullpath' => '/blocks/mambo/module.js',
        'requires' => array('dd-delegate' , 'dd-drop-plugin')
    );

    $PAGE->requires->js_init_call('M.block_mambo.init', array(
        'param1',
        array(
        )
    ), false, $jsmodule);
}