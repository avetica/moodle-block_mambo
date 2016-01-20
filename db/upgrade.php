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
 * upgrade to add more support
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   : block_mambo
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
function xmldb_block_mambo_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2015041500) {

        // Define field name to be added to mambo_widget.
        $table = new xmldb_table('mambo_widget');

        // Adding fields to table mambo_widget.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '9', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('widget', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for mambo_widget.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Mambo savepoint reached.
        upgrade_block_savepoint(true, 2015041500, 'mambo');
    }
    if($oldversion < 2015092912) {
        // Define field name to be added to mambo_behaviour_user
        $table = new xmldb_table('mambo_behaviour_user');
        
        // Adding fields to table
        $field = new xmldb_field('metadata', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        
        // Conditionally launch create table for mambo_widget.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        
        // Mambo savepoint reached.
        upgrade_block_savepoint(true, 2015092912, 'mambo');
    }
    return true;
}