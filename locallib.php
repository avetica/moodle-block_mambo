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
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die();

/**
 * load the module needed to make snapshots
 */
function block_mambo_add_javascript_module() {
    global $PAGE, $COURSE, $CFG;
    $blockid = required_param('blockid', PARAM_INT);
    $jsmodule = array(
        'name' => 'block_mambo',
        'fullpath' => '/blocks/mambo/module.js',
        'requires' => array('dd-delegate', 'dd-drop-plugin', 'io-base', 'dd-scroll')
    );

    $PAGE->requires->js_init_call('M.block_mambo.init', array(
        'courseid' => $COURSE->id,
        'ajaxurl' => $CFG->wwwroot . '/blocks/mambo/ajax.php',
        'sesskey' => sesskey(),
        'blockid' => $blockid,
        array()
    ), false, $jsmodule);
}

/**
 * load JavaScript SDK for the widget with the needed parameters
 */
function block_mambo_add_widget_init() {
    global $PAGE, $USER, $CFG;
    static $mambowidgetinit;

    if ($mambowidgetinit) {
        return;
    }

    $config = get_config('block_mambo');
    $jsmodule = array(
        'name' => 'block_mambo_widget',
        'fullpath' => '/blocks/mambo/widget.js',
        'requires' => array()
    );

    $PAGE->requires->js_init_call('M.block_mambo_widget.init', array(
        'apikey_javascript' => $config->apikey_javascript,
        'api_url' => str_replace(array('http://', 'https://'), '', $config->api_url),
        'site' => $config->site,
        'userid' => (int)$USER->id,
        'apiRoot' => $config->api_url,
        'initoverride' => $config->initoverride,
        'debug' => (int)$config->debug_javascript,
        array()
    ), false, $jsmodule);

    //set to true this will prevent from loading multipull times when there are more blocks on the same page
    $mambowidgetinit = true;
}

/**
 * load a widget linked to this block
 *
 * @param string $content
 * @param int $blockid
 *
 * @return string
 */
function block_mambo_load_widget($content = '', $blockid = 0) {

    if (!empty($content)) {
        $return = '<script>var mamboCallbacks = window.mamboCallbacks || []; '. PHP_EOL;
        $return .= 'mamboCallbacks.push(function() {'. PHP_EOL;
        $return .= $content. PHP_EOL;
        $return .= '});//close push'. PHP_EOL;
        $return .= '</script>' . PHP_EOL;
        $return .= '<div id="mambo_widget_' . $blockid . '" style="min-height:50px"></div>'. PHP_EOL;

        return $return;
    }

    //else no widget found
    return '';
}