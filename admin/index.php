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
require_once '../../auth.inc.php';

// Only let admin users access this page
if (!SEC_hasRights('privacy.admin')) {
    COM_errorLog("Someone has tried to access the Privacy Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_PRIVACY['access_denied']);
    $display .= $LANG_PRIVACY['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}
COM_404();
?>