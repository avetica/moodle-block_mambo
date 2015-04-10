/**
 * Helper for widgets
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author Luuk Verhoeven
 **/

// Initialise the Mambo JavaScript SDK
var mamboCallbacks = window.mamboCallbacks || [];

M.block_mambo_widget = {
    config: {
        'apikey_javascript': '',
        'api_url'          : '',
        'site'         : '',
        'userid'         : 0,
        'wwwroot'          : '',
        'debug'            : false
    },
    log   : function (val)
    {
        try
        {
            console.log(val);
        } catch (e)
        {
        }
    },
    init  : function (Y, apikey_javascript, api_url, site, userid, apiRoot, debug)
    {
        //init params
        this.config.apikey_javascript = apikey_javascript;
        this.config.api_url = api_url;
        this.config.site = site;
        this.config.userid = userid;
        this.config.apiRoot = apiRoot;
        this.config.debug = (debug == 1) ? true : false;

        mamboCallbacks.push(function ()
        {
            var obj = {
                apiRoot : M.block_mambo_widget.config.apiRoot,	// Insert here your Domain URL
                key     : M.block_mambo_widget.config.apikey_javascript,	// Insert here your JavaScript API key
                site    : M.block_mambo_widget.config.site,		// Insert here the Site URL to use
                userUuid: M.block_mambo_widget.config.userid,			// This is the Unique Identifier for the current user
                lang    : 'en'					// Localisation settings. Currently supported: pt (Portuguese) and en (English)
            };

            if(debug)
            {
                M.block_mambo_widget.log('Mambo: Initialise the Mambo JavaScript SDK');
                M.block_mambo_widget.log(obj);
            }

            Mambo.init(obj);
        });

        // Load the Mambo JavaScript SDK Asynchronously
        // Note: the default script is bundled with jQuery. If jQuery is
        // already available, then set the function flag to false.
        (function ()
        {
            var script = document.createElement('script');
            var entry = document.getElementsByTagName('script')[0];
            script.async = true;
            script.src = '//' + M.block_mambo_widget.config.api_url + '/static/widgets/v1/mambo.jquery.min.js';

            if(debug)
            {
                M.block_mambo_widget.log('Mambo:  Load JavaScript SDK');
                M.block_mambo_widget.log(script.src);
            }
            entry.parentNode.insertBefore(script, entry);
        }(true));
    }
}