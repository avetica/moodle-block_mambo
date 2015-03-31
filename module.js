/**
 * Helper for drag-drop activities
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author Luuk Verhoeven
 **/

M.block_mambo = {
    config : {
        'courseid' : 0,
        'ajaxurl' : '',
        'sesskey' : ''
    },
    log : function (val)
    {
        try
        {
            console.log(val);
        } catch (e){
        }
    },
    init: function (Y, courseid , ajaxurl , sesskey)
    {
        this.config.courseid = courseid;
        this.config.ajaxurl = ajaxurl;
        this.config.sesskey = sesskey;

        this.log('INIT: M.block_mambo');

        YUI().use('dd-delegate', 'dd-drop-plugin' , 'io-base', function(Y) {
            var del = new Y.DD.Delegate({
                container: '#mambo_activities',
                nodes: 'li'
            });

            del.on('drag:end', function(e) {
                del.get('currentNode').setStyles({
                    top: 0,
                    left: 0
                });
            });

            var drops = Y.Node.all('#mambo_behaviours ul > li');
            drops.each(function(v, k) {

                // Get a reference to the Node instance
                var a = v;
                a.plug(Y.Plugin.Drop);
                a.drop.on('drop:hit', function(e) {

                    var drag = e.drag.get('node').cloneNode(true);
                    var coursemoduleid = drag.getAttribute('data-id');
                    var verb = a.getAttribute('data-id');

                    M.block_mambo.log('Drop: ' + coursemoduleid + '|' + verb)

                    // we made a clone remove some drag-and-drop attr
                    drag.removeAttribute('id').removeAttribute('style');
                    drag.setAttribute('class' , 'mambobehaviour');

                    // saving the action
                    Y.on('io:complete', M.block_mambo.add_response, Y , [e.drop.get('node').one('ul') , drag]);
                    Y.io(M.block_mambo.config.ajaxurl + '?sesskey=' + M.block_mambo.config.sesskey + '&courseid=' + M.block_mambo.config.courseid + '&action=add&coursemoduleid=' + coursemoduleid + '&verb=' + verb);
                });
            })

            Y.one('#mambo_behaviours').delegate('click', M.block_mambo.delete_node, 'li.mambobehaviour');
        });
    },
    add_response : function(id, o , args)
    {
        try {
            var container = args[0];
            var dragelement = args[1];
            var response = Y.JSON.parse(o.responseText);

            if(response.error)
            {
                alert(response.error);
            }
            else if(response.status == true)
            {
                container.appendChild(dragelement);
            }
            else
            {
                // already added?
            }
        }
        catch (e) {
            M.block_mambo.log(e)
           // alert("JSON Parse failed!");
            return;
        }
    },
    delete_node : function(e)
    {
        var node = e.currentTarget;
        if(node.hasClass('mambobehaviour'))
        {
            // delete a node on click
            var coursemoduleid = node.getAttribute('data-id');
            Y.on('io:complete', M.block_mambo.delete_response, Y , [node]);
            Y.io(M.block_mambo.config.ajaxurl + '?sesskey=' + M.block_mambo.config.sesskey + '&courseid=' + M.block_mambo.config.courseid + '&action=delete&coursemoduleid=' + coursemoduleid + '&verb=holder');
        }
    },
    delete_response : function(id, o , args)
    {
        try {
            var node = args[0];
            var response = Y.JSON.parse(o.responseText);

            if(response.error)
            {
                alert(response.error);
            }
            else if(response.status == true)
            {
                // remove a node on success
                node.remove();
            }
        }
        catch (e) {
            M.block_mambo.log(e)
            // alert("JSON Parse failed!");
            return;
        }
    }
}