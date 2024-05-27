<?php

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox(
        'block_testblock/showcourses',
        get_string('showcourses', 'block_testblock'),
        get_string('showcourses_desc', 'block_testblock'),
        '0'
    ));
}
