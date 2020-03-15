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
 * Define all the backup steps that will be used by the backup_sharedgeogebra_activity_task
 *
 * @package     mod_sharedgeogebra
 * @copyright   2019 Devlion <info@devlion.co>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Structure step to backup one sharedgeogebra activity
 */
class backup_sharedgeogebra_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // Define each element separated.
        $sharedgeogebra = new backup_nested_element(
            'sharedgeogebra',
            ['id'],
            [
                'name',
                'intro',
                'introformat',
                'type',
                'usermodified',
                'timecreated',
                'timemodified'
            ]
        );

        // Define sources.
        $sharedgeogebra->set_source_table('sharedgeogebra', ['id' => backup::VAR_ACTIVITYID]);

        // Define file annotations.
        $sharedgeogebra->annotate_files('mod_sharedgeogebra', 'intro', null);

        // Return the root element (sharedgeogebra), wrapped into standard activity structure.
        return $this->prepare_activity_structure($sharedgeogebra);
    }
}
