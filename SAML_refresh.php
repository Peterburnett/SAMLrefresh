<?php

define('CLI_SCRIPT', true);
require_once('config.php');
global $DB;

$dbman = $DB->get_manager();
// Only execute if SAML plugin in installed
if ($dbman->table_exists('auth_saml2_idps')) {
    // DELETE DB RECORD FOR CONFIG FILE. MAYBE NOT NEEDED
    //$DB->delete_records('config_plugins', array('name' => 'idpmetadata', 'plugin' => 'auth_saml2'));

    //DELETE DB RECORD FOR CURRENT IDPs
    $DB->delete_records('auth_saml2_idps');

    // PURGE CACHES. MAYBE NOT NEEDED
    echo shell_exec('php admin/cli/purge_caches.php');

    // RUN CRONJOB TO FORCE IDPREFRESH
    echo shell_exec("php admin/tool/task/cli/schedule_task.php --execute='\auth_saml2\\task\metadata_refresh'");
} else {
    echo "SAML2 Plugin not installed\n";
}



