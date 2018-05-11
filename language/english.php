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

$LANG_PRIVACY = array (
    'access_denied'     => 'Access Denied',
    'access_denied_msg' => 'You do not have the proper security privilege to access to this page.',
    'read'              => 'I have read and agree to the ',
    'and'               => 'and',
    'terms'             => 'Terms and Conditions',
    'privacy_policy'    => 'Privacy Policy',
    'reg_posttext'      => 'on this site.',
    'personal_data'     => 'Personal Data',
    'download'          => 'Download Personal Data',
    'download_help'     => 'Export the personal data stored on this site in XML format.',
    'no_privacypolicy'  => 'Do not Link to Privacy Policy',
    'no_termsofuse'     => 'Do Not Link to Terms Of Use',
);

// Localization of the Admin Configuration UI
$LANG_configsections['privacy'] = array(
    'label' => 'Privacy',
    'title' => 'Privacy Configuration'
);

$LANG_confignames['privacy'] = array(
    'cookieconsent' => 'Enable Cookie Consent Bar',
    'exportuser'    => 'Add Export Personal Data to My Account Privacy Panel',
    'registrationlinks' => 'Add Links to Privacy Polic / Terms Of Use to Registration Screen',
    'privacypolicy' => 'Privacy Policy Static Page',
    'termsofuse'   => 'Terms Of Use Static Page',
    'cookiestyle' => 'Cookie Bar Style',
    'cookieposition' => 'Cookie Bar Location',
    'cookietext' => 'Text for Cookie Bar',
    'cookielearnmore' => 'Learn More Link',
);

$LANG_configsubgroups['privacy'] = array(
    'sg_main' => 'Configuration Settings'
);

$LANG_fs['privacy'] = array(
    'pv_settings' => 'Privacy Features',
    'pv_cookie'   => 'Consent Cookie Settings',
);

$LANG_configselects['privacy'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('Bottom' => 'bottom', 'Top' => 'top', 'Top (pushdown)' => 'top_pushdown', 'Float Right' => 'bottom-right', 'Float Left' => 'bottom-left'),
    2 => array('Block' => 'block', 'Classic' => 'classic', 'Edgeless' => 'edgeless'),
);

$PLG_privacy_MESSAGE1 = 'Privacy Plugin upgrade: Update completed successfully.';
$PLG_privacy_MESSAGE2 = 'Privacy Plugin upgrade failed - check error.log';
$PLG_privacy_MESSAGE3 = 'Privacy Plugin Successfully Installed';
?>