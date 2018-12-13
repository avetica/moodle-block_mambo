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
$string['btn:addwidget'] = 'Widget creator';
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
$string['initoverride'] = 'INIT override';
$string['select'] = 'You can select a template below';
$string['widget_content'] = 'Widget Content';
$string['addwidget'] = 'Add/Edit a widget';
$string['save'] = 'Save';
$string['widget:edit'] = 'Edit this widget';
$string['widget:new'] = 'Create a new widget';
$string['widget:name'] = 'Name';
$string['widget:code'] = 'Filter Widget code';
$string['widget:actions'] = 'Actions';
$string['edit'] = 'Edit';
$string['new'] = 'New widget';
$string['delete'] = 'Delete';
$string['manual'] = 'Verdeel handmatig punten';

$string['privacy:metadata:mambo'] = 'This table stores actions taken in Mambo';
$string['privacy:metadata:mambo:id'] = 'This table stores actions taken in Mambo';
$string['privacy:metadata:mambo:userid'] = 'The ID of the user that has taken the action';
$string['privacy:metadata:mambo:coursemoduleid'] = 'The course module ID the action in made for';
$string['privacy:metadata:mambo:verb'] = 'The kind of action taken';
$string['privacy:metadata:mambo:completionstate'] = 'The completion state of the module';
$string['privacy:metadata:mambo:send'] = 'Flag for the sending of data';
$string['privacy:metadata:mambo:sendon'] = 'The date the information has been sent';
$string['privacy:metadata:mambo:metadata'] = 'The metadata sent';

$string['privacy:metadata:mambo:external'] = 'The information that goes to the Mambo Service';
$string['privacy:metadata:mambo:ProfileUrl'] = 'The url to your profile';
$string['privacy:metadata:mambo:PictureUrl'] = 'The url to your profile picture';
$string['privacy:metadata:mambo:Ismember'] = 'Flag to define if you are a member';
$string['privacy:metadata:mambo:Email'] = 'The registered email';
$string['privacy:metadata:mambo:FirstName'] = 'The registered firstname';
$string['privacy:metadata:mambo:LastName'] = 'The registered lastname';
$string['privacy:metadata:mambo:DisplayName'] = 'The registered username';
$string['privacy:metadata:mambo:Birthday'] = 'A default date as date of birth';
$string['privacy:metadata:mambo:Gender'] = 'A default gender set as unknown';