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
 * Display information about all the mod_sharedgeogebra modules in the requested course.
 *
 * @package     mod_sharedgeogebra
 * @copyright   2019 Devlion <info@devlion.co>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');

require_once(__DIR__ . '/lib.php');

$id = required_param('id', PARAM_INT);

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
require_course_login($course);

$coursecontext = context_course::instance($course->id);

$event = \mod_sharedgeogebra\event\course_module_instance_list_viewed::create(array(
        'context' => $modulecontext
));
$event->add_record_snapshot('course', $course);
$event->trigger();

$PAGE->set_url('/mod/sharedgeogebra/index.php', array('id' => $id));
$PAGE->set_title(format_string($course->fullname));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($coursecontext);

echo $OUTPUT->header();

$modulenameplural = get_string('modulenameplural', 'mod_sharedgeogebra');
echo $OUTPUT->heading($modulenameplural);

$sharedgeogebras = get_all_instances_in_course('sharedgeogebra', $course);
$strname = get_string("name");
$usesections = course_format_uses_sections($course->format);

if (empty($sharedgeogebras)) {
    notice(get_string('nonewmodules', 'mod_sharedgeogebra'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $strsectionname = get_string('sectionname', 'format_'.$course->format);
    $table->head  = array ($strsectionname, $strname);
    $table->align = array ("center", "left");
} else {
    $table->head  = array ($strname);
}

foreach ($sharedgeogebras as $sharedgeogebra) {
    if (!$sharedgeogebra->visible) {
        $link = html_writer::link(
                new moodle_url('/mod/sharedgeogebra/view.php', array('id' => $sharedgeogebra->coursemodule)),
                format_string($sharedgeogebra->name, true),
                array('class' => 'dimmed'));
    } else {
        $link = html_writer::link(
                new moodle_url('/mod/sharedgeogebra/view.php', array('id' => $sharedgeogebra->coursemodule)),
                format_string($sharedgeogebra->name, true));
    }

    if ($usesections) {
        $table->data[] = array (get_section_name($course, $sharedgeogebra->section), $link);
    } else {
        $table->data[] = array ($link);
    }
}

echo html_writer::table($table);
echo $OUTPUT->footer();
