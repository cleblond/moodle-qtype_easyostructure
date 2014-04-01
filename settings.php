<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('qtype_easyostructure_options', get_string('easyostructure_options', 'qtype_easyostructure'),
                   get_string('configeasyostructureoptions', 'qtype_easyostructure'), '', PARAM_TEXT));
}

