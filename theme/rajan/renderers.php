<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/renderer.php');

class theme_rajan_core_course_renderer extends core_course_renderer
{
    // public function course_section_cm($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = [])
    // {
    //     $format = course_get_format($course);
    //     $course = $format->get_course();

    //     $mod = new \core_courseformat\output\content\cm($mod, $course, $completioninfo, $sectionreturn, $displayoptions);

    //     return $this->render($mod);
    // }
}
