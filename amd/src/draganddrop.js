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
 * Drag and Drop module
 *
 * Since version 2.9, Moodle supports Javascript modules written using the Asynchronous Module Definition (AMD) API.
 * https://docs.moodle.org/dev/Javascript_Modules
 * https://docs.moodle.org/dev/jQuery
 *
 * @package block_mambo
 * @copyright  2016 MoodleFreak.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'jqueryui', 'core/yui'], function ($, Y) {

    /**
     * Option holder
     * @type {{}}
     */
    var options = {
        'courseid': 0,
        'ajaxurl' : '',
        'sesskey' : '',
        'blockid' : 0
    };

    /**
     * Show a log message if debugging is enabled.
     * @param val
     */
    var log = function (val) {
        try {
            console.log(val);
        } catch (e) {
        }
    };

    /**
     * Drag and drop instance
     */
    var draganddrop = {
        init: function () {

            // Draggable items.
            $("#mambo_activities li").draggable({
                cursor     : "move",
                revert     : "invalid", // when not dropped, the item will revert back to its initial position
                containment: "document",
                helper     : "clone",
            });

            // Drop container.
            $("#mambo_behaviours ul > li").droppable({
                classes: {
                    "ui-droppable-active": "ui-state-highlight"
                },
                drop   : function (event, ui) {

                    var $behaviour = $(this);
                    var $item = ui.draggable;
                    var coursemoduleid = $item.data('id');
                    var verb = $behaviour.data('id');

                    log('Drop: ' + coursemoduleid + '|' + verb);

                    // New request.
                    $.ajax({
                        url     : options.ajaxurl,
                        method  : "POST",
                        data    : {
                            'sesskey'       : options.sesskey,
                            'courseid'      : options.courseid,
                            'blockid'       : options.blockid,
                            'action'        : 'add',
                            'verb'          : verb,
                            'coursemoduleid': coursemoduleid,
                        },
                        dataType: "json"
                    })
                    // Response.
                        .done(function (data) {
                            if (data.status) {

                                // Add li to the behaviour.
                                $behaviour.find('ul').append($item.clone());

                            } else if (data.error) {
                                alert(data.error);
                            }
                        })
                        // Error.
                        .fail(function (jqXHR, textStatus) {
                            log("Request failed: " + textStatus);
                        });
                }
            });

            // Delete a dropped item.
            $('#region-main').on('click', '#mambo_behaviours ul li ul li', function () {
                var $item = $(this);
                // New request.
                $.ajax({
                    url     : options.ajaxurl,
                    method  : "POST",
                    data    : {
                        'sesskey'       : options.sesskey,
                        'courseid'      : options.courseid,
                        'blockid'       : options.blockid,
                        'action'        : 'delete',
                        'verb'          : 'holder',
                        'coursemoduleid': $(this).data('id'),
                    },
                    dataType: "json"
                })

                // Response.
                    .done(function (data) {
                        if (data.status) {
                            $item.remove();
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    // Error.
                    .fail(function (jqXHR, textStatus) {
                        log("Request failed: " + textStatus);
                    });
            });
        },
    };

    return {
        initialise: function (params) {

            // Set params.
            options.courseid = params.courseid;
            options.ajaxurl = params.ajaxurl;
            options.sesskey = params.sesskey;
            options.blockid = params.blockid;

            //
            $(document).ready(function () {
                log('INIT AMD: M.block_mambo ');
                draganddrop.init();
            });
        }
    };
});