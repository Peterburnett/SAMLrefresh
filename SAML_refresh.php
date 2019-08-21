<?php

define('CLI_SCRIPT', true);
require_once('config.php');
global $DB;
global $CFG;

use auth_saml2\admin\setting_idpmetadata;

$dbman = $DB->get_manager();
// Only execute if SAML plugin in installed
if ($dbman->table_exists('auth_saml2_idps')) {
    //Get the config currently saved in DB
    $current = get_config('auth_saml2', 'idpmetadata');

    //Construct temp admin control
    $control = new setting_idpmetadata();

    //Wite setting and force update of IdPs
    $control->write_setting($current);
} else {
    echo "SAML2 Plugin not installed\n";
}

