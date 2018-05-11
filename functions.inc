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

// load the language file(s), including custom strings if any

$langfile = $_CONF['path'].'plugins/privacy/language/' . $_CONF['language'] . '.php';
$custfile = $_CONF['path'].'plugins/privacy/language/custom/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    include_once $langfile;
    if (file_exists($custfile)) {
        include_once $custfile;
    }
} else {
    $langfile = $_CONF['path'].'plugins/privacy/language/english.php';
    $custfile = $_CONF['path'].'plugins/privacy/language/custom/english.php';
    include_once $langfile;
    if (file_exists($custfile)) {
        include_once $custfile;
    }
}

$pv_config = config::get_instance();
$_PV_CONF = $pv_config->get_config('privacy');

require_once $_CONF['path'].'plugins/privacy/privacy.php';

/**
 * Return plugin's version information
 *
 * @return  string   plugin version number
 */
function plugin_chkVersion_privacy() {
    global $_PV_CONF;

    return $_PV_CONF['pi_version'];
}

/**
 * Upgrade plugin
 *
 * @return  string   plugin version number
 */
function plugin_upgrade_privacy() {
    global $_CONF, $_TABLES;

    require_once $_CONF['path'].'plugins/privacy/upgrade.php';

    return privacy_upgrade();
}

/**
* This will put an option for forum admin in the command and control block on moderation.php
*
*/
function plugin_cclabel_privacyXX()
{
    global $_CONF;

    if (SEC_hasRights('privacy.admin')) {
        return array('Privacy',$_CONF['site_admin_url'].'/plugins/privacy/index.php',$_CONF['site_url'].'/privacy/images/privacy.png');
    }
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_privacyXX()
{
    global $_TABLES, $_CONF;

    if (SEC_hasRights('privacy.admin')) {
        return array('Privacy', $_CONF['site_admin_url'] . '/plugins/privacy/index.php', '');
    }
}


/**
 * Return URL to configuration documentation
 *
 * @return  string   Full URL to configuration documentation
 */
function plugin_getconfigelementhelp_privacy($type, $option, $doclang = 'english' )
{
    global $_CONF;

    $retval = '';

    $baseUrl = $_CONF['site_url'];
    $cfg = 'privacy/docs/' . $doclang . '/config.html';
    if (@file_exists($_CONF['path_html'].$cfg)) {
        $descUrl = $baseUrl . '/' . $cfg;
    } else {
        $descUrl = $baseUrl . '/plugins/privacy/docs/english/config.html';
    }
    $retval = $descUrl;

    return array($retval,0);
}

/**
 * Adds Download Personal Data button to Privacy panel in account profile
 *
 * @return  string   formatted HTML for display
 */
function plugin_profileedit_privacy($uid,$panel,$fieldset)
{
    global $_CONF, $_PV_CONF, $_USER, $LANG_PRIVACY;

    $retval = '';

    if ( $_PV_CONF['exportuser'] != true ) return $retval;

    if ( COM_isAnonUser() ) {
        return $retval;
    }

    if ( $uid != $_USER['uid']) return $retval;

    if ( $panel == 'privacy' && $fieldset == 'privacy' ) {

        $token = SEC_createTokenGeneral('export');

        $T = new Template($_CONF['path'] . 'plugins/privacy/templates/');
        $T->set_file ('profilehook','profile.thtml');
        $T->set_var (array(
                'lang_personal_data'    => $LANG_PRIVACY['personal_data'],
                'lang_download'         => $LANG_PRIVACY['download'],
                'lang_download_help'    => $LANG_PRIVACY['download_help'],
                'token'                 => $token,
        ));

        $T->parse ('output', 'profilehook');
        $retval = $T->finish ($T->get_var('output'));

        return $retval;
    }

    if ($panel != '' || $fieldset != '' ) {
        return $retval;
    }
    return $retval;
}

/**
 * Adds links to privacy policy and terms of use to registration, if they exist
 *
 * @return  string   formatted HTML for display
 */
function plugin_templatesetvars_privacy($templatename, $template)
{
    global $_CONF, $_PV_CONF, $_TABLES, $_PLUGIN_INFO, $LANG_PRIVACY, $LANG_STATIC;

    if ( $templatename != 'registration' && $templatename != 'footer' ) return;

    switch ($templatename) {
        case 'registration' :
            if ( $_PV_CONF['registrationlinks'] != true ) break;
            if ( !isset($_PLUGIN_INFO['staticpages'])) return;
            if ($_PV_CONF['privacypolicy'] == '' && $_PV_CONF['termsofuse'] == '' ) return;

            $retval = '';
            $termsOfUse = '';
            $privacyPolicy = '';

            if ( $_PV_CONF['termsofuse'] != '' ) {
                $id = DB_getItem($_TABLES['staticpage'],'sp_id',"sp_id='".DB_escapeString($_PV_CONF['termsofuse'])."'");
                if ( $id != '' ) {
                    $url = COM_buildUrl( $_CONF['site_url'] . '/page.php?page=' . $_PV_CONF['termsofuse']);
                    $termsOfUse = COM_createLink($LANG_PRIVACY['terms'], $url,array('target'=>'_blank','title'=>$LANG_STATIC['title_display']));
                }
            }
            if ( $_PV_CONF['privacypolicy'] != '' ) {
                $id = DB_getItem($_TABLES['staticpage'],'sp_id',"sp_id='".DB_escapeString($_PV_CONF['privacypolicy'])."'");
                if ( $id != '' ) {
                    $url = COM_buildUrl( $_CONF['site_url'] . '/page.php?page=' . $_PV_CONF['privacypolicy']);
                    $privacyPolicy = COM_createLink($LANG_PRIVACY['privacy_policy'], $url,array('target'=>'_blank','title'=>$LANG_STATIC['title_display']));
                }
            }
            if ($privacyPolicy != '' || $termsOfUse != '' ) {
                $T = new Template($_CONF['path'] . 'plugins/privacy/templates/');
                $T->set_file ('registrationhook','registration.thtml');
                $T->set_var (array(
                        'lang_read'             => $LANG_PRIVACY['read'],
                        'lang_and'              => $LANG_PRIVACY['and'],
                        'lang_posttext'         => $LANG_PRIVACY['reg_posttext'],
                ));
                if ( $termsOfUse != '' ) {
                    $T->set_var('termsofuse', $termsOfUse);
                }
                if ( $privacyPolicy != '' ) {
                    $T->set_var('privacypolicy',$privacyPolicy);
                }

                $T->parse ('output', 'registrationhook');
                $retval = $T->finish ($T->get_var('output'));
            }
            $template->set_var('plugin_bottom', $retval);
            break;
        case 'footer' :

            if ( $_PV_CONF['cookieconsent'] != 1 ) return;

            $T = new Template($_CONF['path'] . 'plugins/privacy/templates/');
            $T->set_file ('consent','cookieconsent.thtml');

            $T->set_var(array(
                'theme' => $_PV_CONF['cookiestyle'] == 'block' ? '' : $_PV_CONF['cookiestyle'],
                'showlink' => $_PV_CONF['cookielearnmore'],
                'position' => $_PV_CONF['cookieposition'],
            ));
            if ( $_PV_CONF['cookieposition'] == 'top_pushdown' ) {
                $T->set_var(array(
                    'position' => 'top',
                    'static'   => 'true',
                ));
            }
            $T->parse ('output', 'consent');
            $retval = $T->finish ($T->get_var('output'));
            $template->set_var('raw-footer', $retval);
            break;
    }
}

function plugin_itemPreSave_privacy($type, $content)
{
    global $_CONF, $_PV_CONF, $LANG_PRIVACY;

    if ( $type != 'registration') return;

    if ( isset($_POST['privacy-confirm']) && $_POST['privacy-confirm'] == 'on' ) return;

    return 'Please confirm you have read and agree to the terms.';

}

/**
 * Exports user data in XML format
 *
 * @return  string   formatted HTML for display
 */
function PRIVACY_export()
{
    global $_CONF, $_TABLES, $_USER, $LANG_PRIVACY, $LANG_CHARSET;

    if ( COM_isAnonUser() ) die();

    if ( !isset($_GET['t'])) die();

    $token = COM_applyFilter($_GET['t']);
    if (!SEC_checkTokenGeneral($token,'export',$_USER['uid'])) die();

    // account profile information to export

    $toExport = array('uid','username','remoteusername','remoteservice','fullname','email','homepage','sig','regdate','photo','remote_ip','tzid','emailstories','emailfromadmin','emailfromuser','showonline','search_result_format','about','location','pgpkey','userspace','totalcomments','lastlogin');

    $exportData = '';
    foreach ($_USER AS $item => $value) {
        if ( in_array($item,$toExport) ) {
            if ( $item == 'lastlogin' ) {
                $dt = new Date($value,$_USER['tzid']);
                $value = $dt->format($dt->getUserFormat(),true);
            }
            $exportData .= '<'.$item.'>'.addSlashes($value).'</'.$item.'>'.LB;
        }
    }

    $pluginData = PLG_privacyExport($_USER['uid'],$_USER['email'],$_USER['username'],$_USER['remote_ip']);

    header("Content-type: application/octet-stream");
    header("Content-Disposition: inline; filename=\"userinfo.xml\"");
	echo "<?xml version=\"1.0\" encoding=\"" . $LANG_CHARSET . "\"?>\n";
	echo "<userData>\n";
	echo "<userProfile>\n";
	echo $exportData;
    echo "</userProfile>\n";

    if ( $pluginData != '' ) {
        echo $pluginData;
    }
    echo "</userData>";

    die();
}


function plugin_getheadercode_privacy()
{
    global $_CONF, $_PV_CONF;

    if ( $_PV_CONF['cookieconsent'] != 1 ) return;

    $outputHandle = outputHandler::getInstance();
    $outputHandle->addLinkScriptFooter($_CONF['site_url'].'/privacy/js/cookieconsent.min.js');
    $outputHandle->addLinkStyle($_CONF['site_url'].'/privacy/js/cookieconsent.min.css');
    return;
}


// function for testing - disabled in prod
function plugin_privacy_export_privacyXX($uid,$email='',$username='',$ip='')
{
    $retval = '';

    $retval .= "<forum>\n";
    $retval .= "<post>Some post data</post>\n";
    $retval .= "<post>Some more post data</post>\n";
    $retval .= "</forum>\n";

    return $retval;
}

/**
* Helper function: Provide themes dropdown
*
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Beautifying code duplicated from usersettings.php
*
*/
function plugin_configmanager_select_privacypolicy_privacy()
{
    global $_CONF, $_PV_CONF, $_TABLES, $_USER, $_PLUGIN_INFO, $LANG_PRIVACY;

    if ( !isset($_PLUGIN_INFO['staticpages'])) return;

    $pages = array();

    $pages[$LANG_PRIVACY['no_privacypolicy']] = '';

    $result = DB_query("SELECT sp_id, sp_title FROM {$_TABLES['staticpage']} WHERE sp_status = 1 " . COM_getPermSql('AND'). " ORDER BY sp_title ASC");
    $rows = DB_fetchAll($result);
    foreach($rows AS $row) {
        $pages[htmlentities($row['sp_title'])] = $row['sp_id'];
    }

    return $pages;
}

/**
* Helper function: Provide themes dropdown
*
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Beautifying code duplicated from usersettings.php
*
*/
function plugin_configmanager_select_termsofuse_privacy()
{
    global $_CONF, $_PV_CONF, $_TABLES, $_USER, $_PLUGIN_INFO, $LANG_PRIVACY;

    if ( !isset($_PLUGIN_INFO['staticpages'])) return;

    $pages = array();
    $pages[$LANG_PRIVACY['no_termsofuse']] = '';
    $result = DB_query("SELECT sp_id, sp_title FROM {$_TABLES['staticpage']} WHERE sp_status = 1 " . COM_getPermSql('AND'). " ORDER BY sp_title ASC");
    $rows = DB_fetchAll($result);
    foreach($rows AS $row) {
        $pages[htmlentities($row['sp_title'])] = $row['sp_id'];
    }

    return $pages;
}

function PRIVACY_cleanXML($text)
{


    return $text;

}
?>