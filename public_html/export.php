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

require_once '../lib-common.php';

if ( COM_isAnonUser() ) die();

if ( !isset($_GET['t'])) die();

$token = COM_applyFilter($_GET['t']);
if (!SEC_checkTokenGeneral($token,'export',$_USER['uid'])) {
    header("Content-type: application/octet-stream");
    header("Content-Disposition: inline; filename=\"userinfo.xml\"");
    echo "Security check failed - please try again\n";
    die();
}

PRIVACY_export();
?>