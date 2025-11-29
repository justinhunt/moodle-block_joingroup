# JoinGroup block for Moodle

This block allows the student to enter a group enrolment key to join a group.
It is useful when the enrolment method (e.g Stripe) does not support enroling students into groups with a key. 
[20s Demo Video](https://youtu.be/AV12_Nciwxc)

## Installation

Unzip , or git clone the plugin into the Moodle site's "blocks" folder. The plugin folder should be called "joingroup" and it should contain files like lib.php and version.php. If those files are in a sub-folder, your folder structure is not correct.

The only setting during installation is what to call "group" in the user interface. By default it is "Group" but the following options are also available:
- Teacher
- Instructor
- Class
- Team
- House
- Room
- Department
- Circle
- Company
- School

Finally, visit your site's *Site administration -> Plugins -> Blocks -> Manage Blocks* and enable "Join Group"


## Adding the Block to a Course

On the course page, put the course into edit mode and "Add a block." If you do not see "Join Group" in the list of options then you will need to visit the Site Administration and make sure it is enabled.

## Usage

The student will see an area to enter their group enrolment key when they are on the course page. They simply enter their code and press the Join button. They can also leave if they wish.

NB The groups MUST have group enrolment keys set up. To access group administration in Moodle, from the course page visit the participants page. It is not very clear but just beside the "Enrolled Users" title there is a little arrow click to expose participant related settings including Groups. In the group edit or creation pages there is a place to specify a group key.


### Alternative Plugin
An alternative plugin to JoinGroup is Nicolas Dunand's [mod_choicegroup](https://github.com/ndunand/moodle-mod_choicegroup) which does not require keys but does expose the list of groups in the course to the student.
