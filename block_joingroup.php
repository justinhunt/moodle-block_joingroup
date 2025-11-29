<?php
class block_joingroup extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_joingroup');
    }

    public function has_config() {
        return true;
    }

    public function get_content()
    {
        global $CFG, $USER, $COURSE, $OUTPUT, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if (!isloggedin() || isguestuser()) {
            return $this->content;
        }

        // The name of the thing(group) students join.
        $jointhing = get_config('block_joingroup', 'jointhing');
        if (!empty($jointhing)) {
            $jointhing = get_string($jointhing, 'block_joingroup');
        }
        $this->title = get_string('joingroup', 'block_joingroup', $jointhing);

        // Get the course context.
        $context = context_course::instance($COURSE->id);

        // Check if user is enrolled.
        if (!is_enrolled($context, $USER, '', true)) {
            return $this->content;
        }

        // Get user's groups in this course.
        $usergroups = groups_get_all_groups($COURSE->id, $USER->id);

        if (!empty($usergroups)) {
            // User is in one or more groups.
            $this->content->text .= html_writer::tag('p', get_string('alreadyingroup', 'block_joingroup'));
            $this->content->text .= html_writer::start_tag('ul', array('class' => 'list-unstyled'));

            foreach ($usergroups as $group) {
                $groupname = format_string($group->name);
                $grouppicture = print_group_picture($group, $COURSE->id, false, true, true);

                $leaveurl = new moodle_url('/blocks/joingroup/process.php', array(
                    'action' => 'leave',
                    'groupid' => $group->id,
                    'courseid' => $COURSE->id,
                    'sesskey' => sesskey()
                ));

                // Confirmation JS
                $confirmsg = get_string('leaveconfirm', 'block_joingroup', $groupname);

                $button = new single_button($leaveurl, get_string('leave', 'block_joingroup', $jointhing));
                $button->add_confirm_action($confirmsg);
                $button->class = 'btn btn-secondary btn-sm'; // Try to keep styling similar if possible, though single_button renders a form.

                $this->content->text .= html_writer::start_tag('li', array('class' => 'mb-2'));
                $this->content->text .= html_writer::div($grouppicture . ' ' . $groupname, 'd-flex align-items-center mb-1');
                $this->content->text .= $OUTPUT->render($button);
                $this->content->text .= html_writer::end_tag('li');
            }
            $this->content->text .= html_writer::end_tag('ul');

        } else {
            // User is not in any group. Show Join Form.
            $url = new moodle_url('/blocks/joingroup/process.php');

            $this->content->text .= html_writer::start_tag('form', array('action' => $url, 'method' => 'post', 'class' => 'm-t-1'));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'courseid', 'value' => $COURSE->id));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'action', 'value' => 'join'));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()));

            $this->content->text .= html_writer::div(
                html_writer::label(get_string('enterkey', 'block_joingroup', $jointhing), 'groupkey') .
                html_writer::empty_tag('input', array(
                    'type' => 'text',
                    'name' => 'groupkey',
                    'id' => 'groupkey',
                    'class' => 'form-control'
                )),
                'form-group'
            );

            $this->content->text .= html_writer::empty_tag('input', array(
                'type' => 'submit',
                'value' => get_string('join', 'block_joingroup', $jointhing),
                'class' => 'btn btn-primary'
            ));

            $this->content->text .= html_writer::end_tag('form');
        }

        return $this->content;
    }
}
