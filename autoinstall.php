<?php
/**
 * glFusion Privacy Plugin
 *
 * Additional Privacy Controls for glFusion
 *
 * LICENSE: This program is free software; you can redistribute it
 *  and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * @category   glFusion CMS
 * @package    glFusion
 * @author     Mark R. Evans  mark AT glFusion DOT org
 * @copyright  2018 - Mark R. Evans
 * @license    http://opensource.org/licenses/gpl-2.0.php - GNU Public License v2 or later
 *
 */

if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

global $_DB_dbms;

require_once $_CONF['path'].'plugins/privacy/functions.inc';
include $_CONF['path'].'plugins/privacy/privacy.php';

// +--------------------------------------------------------------------------+
// | Plugin installation options                                              |
// +--------------------------------------------------------------------------+

$INSTALL_plugin['privacy'] = array(
  'installer' => array('type' => 'installer', 'version' => '1', 'mode' => 'install'),

  'plugin' => array('type' => 'plugin', 'name' => $_PV_CONF['pi_name'],
        'ver' => $_PV_CONF['pi_version'], 'gl_ver' => $_PV_CONF['gl_version'],
        'url' => $_PV_CONF['pi_url'], 'display' => $_PV_CONF['pi_display_name']),

  array('type' => 'group', 'group' => 'Privacy Admin', 'desc' => 'Users in this group can administer the Privacy plugin',
        'variable' => 'admin_group_id', 'addroot' => true, 'admin' => true),

  array('type' => 'feature', 'feature' => 'privacy.admin', 'desc' => 'Ability to administer the Privacy Plugin',
        'variable' => 'admin_feature_id'),

  array('type' => 'mapping', 'group' => 'admin_group_id', 'feature' => 'admin_feature_id',
        'log' => 'Adding feature to the admin group'),
);


/**
* Puts the datastructures for this plugin into the glFusion database
*
* Note: Corresponding uninstall routine is in functions.inc
*
* @return   boolean True if successful False otherwise
*
*/
function plugin_install_privacy()
{
    global $INSTALL_plugin, $_PV_CONF;

    $pi_name            = $_PV_CONF['pi_name'];
    $pi_display_name    = $_PV_CONF['pi_display_name'];
    $pi_version         = $_PV_CONF['pi_version'];

    COM_errorLog("Attempting to install the $pi_display_name plugin", 1);

    $ret = INSTALLER_install($INSTALL_plugin[$pi_name]);
    if ($ret > 0) {
        return false;
    }

    return true;
}

/**
* Loads the configuration records for the Online Config Manager
*
* @return   boolean     true = proceed with install, false = an error occured
*
*/
function plugin_load_configuration_privacy()
{
    global $_CONF;

    require_once $_CONF['path'].'plugins/privacy/install_defaults.php';

    return plugin_initconfig_privacy();
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_privacy ()
{

    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array(),
        /* give the full name of the group, as in the db */
        'groups' => array('Privacy Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('privacy.admin'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}
?>