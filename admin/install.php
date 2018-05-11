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

require_once '../../../lib-common.php';
require_once $_CONF['path'].'plugins/privacy/autoinstall.php';

USES_lib_install();

/**
* Only let Root users access this page
*/
if (!SEC_inGroup('Root')) {
    /**
    * Someone is trying to illegally access this page
    */
    COM_errorLog("Someone has tried to access the Privacy Plugin install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    $display = COM_siteHeader()
    . COM_startBlock($LANG_PV00['access_denied'])
    . $LANG_PV00['access_denied_msg']
    . COM_endBlock()
    . COM_siteFooter(true);
    echo $display;
    exit;
}

/**
* Main Function
*/
if (SEC_checkToken()) {
    $action = COM_applyFilter($_GET['action']);
    if ($action == 'install') {
        if (plugin_install_privacy()) {
            // Redirects to the plugin editor
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=44');
            exit;
        } else {
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=72');
            exit;
        }
    } else if ($action == 'uninstall') {
        if (plugin_uninstall_privacy('installed')) {
            /**
            * Redirects to the plugin editor
            */
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=45');
            exit;
        } else {
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=73');
            exit;
        }
    }
}

echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php');
?>