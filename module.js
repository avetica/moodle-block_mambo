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
    init: function (Y, applicationpath, expresspath, flashvars)
    {
        this.log('INIT: M.block_mambo');

        YUI().use('dd-delegate', 'dd-drop-plugin', function(Y) {
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


            var drops = Y.Node.all('#mambo_points ul li');
            drops.each(function(v, k) {
                M.block_mambo.log('LI');

                // Get a reference to the Node instance
                var a = v;
                a.plug(Y.Plugin.Drop);
                a.drop.on('drop:hit', function(e) {

                    M.block_mambo.log('Drop')

                    var drag = e.drag.get('node').cloneNode(true);

                    // we made a clone remove some drag-and-drop attr
                    drag.removeAttribute('id').removeAttribute('style');

                    e.drop.get('node').one('ul').appendChild(drag);
                    // drop.set('innerHTML', 'You dropped: <strong>' + e.drag.get('node').get('innerHTML') + '</strong>');
                });
            })
        });
    }
}