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
 * html render class
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
class block_mambo_renderer extends plugin_renderer_base {

    /**
     * get overview of mapped activities
     *
     * @param \block_mambo\activities $activities
     * @param mixed $behaviours result from mambo
     * @param stdClass $course  Moodle course object.
     *
     * @return string html content
     */
    public function activities_overview(\block_mambo\activities $activities, $behaviours, $course) {
        $html = '<div id="mambo_mapping_wrapper">';
        $items = $activities->get_mapping_activities($course, $behaviours);


        // build activity list
        if (!empty($items['activities'])) {
            $html .= '<div id="mambo_activities">
                        <h3>' . get_string('heading:mambo_activities', 'block_mambo') . '</h3>
                        <p>' . get_string('desc:mambo_activities', 'block_mambo') . '</p>
                        <ul>';

            foreach ($items['activities'] as $activityid => $activity) {
                $html .= '<li data-id="' . $activityid . '">' . $activity->displayname . '</li>';
            }

            $html .= '</ul>
                   </div>';
        }

        // build points list get by mambo
        if (!empty($items['behaviours'])) {
            $html .= '<div id="mambo_behaviours">
                            <h3>' . get_string('heading:mambo_behaviours', 'block_mambo') . '</h3>
                            <p>' . get_string('desc:mambo_behaviours', 'block_mambo') . '</p>
                        <ul>';

            foreach ($items['behaviours'] as $behaviour) {
                $html .= '<li data-id="' . $behaviour->verb . '"><b>' . $behaviour->attrs->type . ': ' . $behaviour->name . '</b>';
                $html .= $this->mappeditems($behaviour, $items['activities']);
                $html .= '</li>';
            }

            $html .= '</ul>
                   </div>';
        }
        $html .= '</div>'; // end main wrapper
        return $html;
    }

    /**
     * format behaviours already connected
     *
     * @param $behaviour
     * @param $activities
     *
     * @return string
     */
    protected function mappeditems($behaviour, $activities) {
        $html = '<ul>';
        if (!empty($behaviour->items)) {
            foreach ($behaviour->items as $item) {
                if (isset($activities[$item->coursemoduleid]->displayname)) {
                    $html .= '<li class="mambobehaviour" data-id="' . $item->coursemoduleid . '">' . $activities[$item->coursemoduleid]->displayname . '</li>';
                }
            }
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * get overview of all widget and there codes
     * @return string
     */
    public function list_all_widgets() {
        global $DB, $PAGE;

        $table = new html_table();
        $table->align = array('left', 'left');
        $table->attributes['class'] = 'generaltable titlesleft';
        $table->data = array();
        $table->head = array(get_string('widget:code' , 'block_mambo') , get_string('widget:name' , 'block_mambo') ,  get_string('widget:actions' , 'block_mambo') );

        $results = $DB->get_records('mambo_widget');
        foreach ($results as $result) {
            $linkedit = new moodle_url($PAGE->url);
            $linkedit->param('widgetid' , $result->id);

            $linkedelete = clone $linkedit;
            $linkedelete->param('action' , 'delete');
            $table->data[] = array('[mambo-widget-' . $result->id . ']', $result->name, html_writer::link($linkedit , get_string('edit' , 'block_mambo')) . ' &nbsp; ' . html_writer::link($linkedelete , get_string('delete' , 'block_mambo')));
        }

        return html_writer::table($table);
    }
}
