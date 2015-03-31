/**
 * Helper for drag-drop courses
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author Luuk Verhoeven
 **/

M.block_mambo = {
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

            var drops = Y.Node.all('#mambo_points ul > li');
            drops.each(function(v, k) {
                M.block_mambo.log('LI');

                // Get a reference to the Node instance
                var a = v;
                a.plug(Y.Plugin.Drop);
                a.drop.on('drop:hit', function(e) {

                    M.block_mambo.log('Drop')

                    var drag = e.drag.get('node').cloneNode(true);
                    var coursemoduleid = drag.getAttribute('data-id');
                    var mamboid = a.getAttribute('data-id');


                    M.block_mambo.log('Drop: ' + coursemoduleid + '|' + mamboid)

                    // we made a clone remove some drag-and-drop attr
                    drag.removeAttribute('id').removeAttribute('style');


                    // saving the action
                    Y.on('io:complete', M.block_mambo.response_request, Y , [e.drop.get('node').one('ul') , drag]);
                    var request = Y.io(ajaxurl + '?sesskey=' + sesskey + '&courseid=' + courseid + '&action=add&coursemoduleid=' + coursemoduleid + '&mamboid=' + mamboid);
                });
            })
        });
    },
    response_request : function(id, o , args)
    {
        try {
            var container = args[0];
            var dragelement = args[1];
            var response = Y.JSON.parse(o.responseText);

            if(response.error)
            {
                alert(response.error);
            }

            if(response.status == true)
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
    }
}