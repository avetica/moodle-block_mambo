/**
 * Helper for widgets
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author Luuk Verhoeven
 **/

 /**
  * @module block_mambo/mamboinit
  */

// Shim the requireJS config.
// This is required because the Mambo library itself is using anonymous (define) functions.
window.requirejs.config({
    paths: {
        "mambo": '//mamboio01.avetica.net/static/widgets/v1/mambo.jquery.min'
    },
    shim: {
        'mambo': {
            deps: ['jquery', 'block_mambo/mamboinit'],
            exports: 'Mambo'
        }
    }
});

define([], function() {
    return {
        // Set up a function to receive parameters from PHP.
        setupmambocallbacks : function(api_url, apikey_javascript, site, uuid) {
            console.log(api_url, apikey_javascript, site, uuid);
            window.mamboCallbacks.unshift(function() {
                Mambo.init({
                    apiRoot: 'https://' + api_url,
                    key: apikey_javascript,
                    site: site,
                    userUuid: uuid,
                    lang: 'en',
                    levelGroups: [{
                                label       : "Overall Experience",
                                tags        : ["primary_level"],
                                isDefault   : true, 
                                isPrimary   : true, 
                                noLabels    : false,
                    }],
                    notifications: {
                        withActivities: true,
                    }
                });
            });
        }

    }
});
