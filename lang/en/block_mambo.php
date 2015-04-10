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
* EN lang
*
* @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*
* @package   block_mambo
* @copyright 2015 MoodleFreak.com
* @author    Luuk Verhoeven
**/
$string['mambo:addinstance'] = 'Add a MamboIO Gamification Block';
$string['mambo:myaddinstance'] = 'Add a MamboIO Gamification Block to My home';
$string['pluginname'] = 'MamboIO Gamification';
$string['apikey_private'] = 'Private key';
$string['apikey_public'] = 'Public key';
$string['apikey_javascript'] = 'JavaScript API key';
$string['api_url'] = 'end point URL';
$string['select_a_site'] = 'Select your site name below';
$string['sites'] = 'List of sites available';
$string['debug'] = 'Debug API';
$string['debug_javascript'] = 'Debug Javascript to console';
$string['task'] = 'Sync data to MamboIO';
$string['btn:setup'] = 'Configure mambo mapping';
$string['btn:addwidget'] = 'Widget config';
$string['mambo:view'] = 'View MamboIO Block';
$string['heading:mambo_behaviours'] = 'Mambo Behaviours';
$string['failed:capability_view'] = 'Mambo Points';
$string['heading:mambo_activities'] = 'Activities';
$string['activitiespage'] = 'List of activities';
$string['widgetpage'] = 'Widget configuration';
$string['site_missing'] = 'Please select your MamboIO site from the dropdown in the block settings.';
$string['desc:mambo_behaviours'] = 'You can drag-and-drop activities from the left and place them on a mambo behaviour';
$string['desc:mambo_activities'] = 'All available activities that has completion enabled.';
$string['pluginname_desc'] = 'You will find your OAuth API keys on <a href="http://api.mambo.io/#dev">http://api.mambo.io/#dev</a>';


$string['template'] = 'Template';
$string['select'] = 'You can select a template below';
$string['widget_content'] = 'Widget Content';
$string['template_helper'] = '<pre>
&lt;script&gt;
var <strong>mamboCallbacks</strong> = window.<strong>mamboCallbacks</strong> || [];

mamboCallbacks.push(function() {

<span style="background: yellow"><strong>## your content above will be added here. Keep in mind it includes the correct id of div bellow ##</strong></span>

});

&lt;/script&gt;
&lt;div id=&quot;<span style="background: yellow">mambo_widget_{$a->id}</span>&quot; style=&quot;position:absolute;&quot;&gt;&lt;/div&gt;</pre>';
