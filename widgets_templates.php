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
 *
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   : block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
defined('MOODLE_INTERNAL') || die();
$templates = array();
$templates['profile'] = 'Mambo( \'#mambo_widget_##BLOCKID##\' ).profile({
        hasPicture: true,
        hasProfileLink: false,
        hideOnError: false,
        hasEarnPoints: true,
        earnPointsUrl: null,
        tabs: {
hasMissions: true,
            hasLevels: true,
            hasAchievements: true,
            hasCoupons: true
        },
        pointOpts: {
show: true,
            type: \'all\',
            img: true,
            abbr: true,
            exclude: [\'549c0f26a95dfabe4a5e49ff\'],
            include: [\'549c0f1ba95dfabe4a5e49fe\']
        }
    });';
$templates['earnPoints'] = 'Mambo( \'#mambo_widget_##BLOCKID##\' ).earnPoints({
    width: 600
});
Mambo().earnPoints({
        popup: true
    });';
$templates['leaderboard'] = 'Mambo( \'#mambo_widget_##BLOCKID##\' ).leaderboard({
    period: "week",
    leaderboardId: null,
    behaviourId: null,
    title: null,
    height: 425,
    width: 250,
    iconClass: "k-ldr-ico",
    picClass: "k-sprite k-sil-m",
    widgetOpts: {
        hasEarnPoints: true,
        earnPointsUrl: null,
        height: 500,
        width: 250
    }
});';
$templates['activities'] = 'Mambo( \'#mambo_widget_##BLOCKID##\' ).activities({
    height: 425,
    width: 250,
    iconClass: "k-act-ico",
    picClass: "k-sprite k-sil-m",
    widgetOpts: {
        hasEarnPoints: true,
        earnPointsUrl: null,
        height: 500,
        width: 250
    }
});';
$templates['header'] = 'Mambo( \'#mambo_widget_##BLOCKID##\' ).header({
			height: 20,
			hasPicture: false,
			hasLevel: true,
			hasSummary: true,
			isTop: false,
			showLeft: false,
			isEmbedded: false,
			isSimple: true,
			hideOnError: false,
			profileLink: null,
			userName: "fullName",
			pointOpts: {
    show: true,
				type: \'all\',
				img: true,
				abbr: true,
				exclude: [\'549c0f26a95dfabe4a5e49ff\'],
				include: [\'549c0f1ba95dfabe4a5e49fe\']
			},
			profileOpts: {
    // Profile options go here
}
		});';