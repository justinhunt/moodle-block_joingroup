<?php
require_once('../../config.php');
require_once($CFG->dirroot . '/group/lib.php');

$courseid = required_param('courseid', PARAM_INT);
$action = required_param('action', PARAM_ALPHA);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$url = new moodle_url('/course/view.php', array('id' => $courseid));

require_login($course);
require_sesskey();

$context = context_course::instance($courseid);
$jointhing = get_config('block_joingroup', 'jointhing');
if (!empty($jointhing)) {
    $jointhing = get_string($jointhing, 'block_joingroup');
}


if ($action === 'join') {
    $groupkey = required_param('groupkey', PARAM_RAW); // Keys can have special chars.

    if (empty($groupkey)) {
        redirect($url, get_string('invalidkey', 'block_joingroup', $jointhing), null, \core\output\notification::NOTIFY_ERROR);
    }

    // Find the group with this key.
    // We use get_records to avoid errors if duplicates exist, though that would be a config issue.
    $groups = $DB->get_records('groups', array('courseid' => $courseid, 'enrolmentkey' => $groupkey));

    if (empty($groups)) {
        redirect($url, get_string('nogroupfound', 'block_joingroup', $jointhing), null, \core\output\notification::NOTIFY_ERROR);
    }

    // Join the first matching group.
    $group = reset($groups);

    // Check if already a member.
    if (groups_is_member($group->id, $USER->id)) {
        redirect($url, get_string('alreadyingroup', 'block_joingroup'), null, \core\output\notification::NOTIFY_WARNING);
    }

    // Add member.
    if (groups_add_member($group->id, $USER->id)) {
        redirect($url, get_string('successjoin', 'block_joingroup', format_string($group->name)), null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        redirect($url, get_string('errorjoin', 'block_joingroup', $jointhing), null, \core\output\notification::NOTIFY_ERROR);
    }

} elseif ($action === 'leave') {
    $groupid = required_param('groupid', PARAM_INT);
    $group = $DB->get_record('groups', array('id' => $groupid, 'courseid' => $courseid), '*', MUST_EXIST);

    if (groups_is_member($group->id, $USER->id)) {
        if (groups_remove_member($group->id, $USER->id)) {
            redirect($url, get_string('successleave', 'block_joingroup', format_string($group->name)), null, \core\output\notification::NOTIFY_SUCCESS);
        } else {
            redirect($url, get_string('errorleave', 'block_joingroup'), null, \core\output\notification::NOTIFY_ERROR);
        }
    } else {
        redirect($url, get_string('notingroup', 'block_joingroup', $jointhing), null, \core\output\notification::NOTIFY_WARNING);
    }
} else {
    redirect($url);
}
