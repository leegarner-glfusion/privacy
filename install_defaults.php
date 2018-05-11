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

/**
*   Initialize agenda plugin configuration
*
*   @return boolean             true: success; false: an error occurred
*/
function plugin_initconfig_privacy()
{
    global $_CONF;

    $c = config::get_instance();

    if (!$c->group_exists('privacy')) {
        require_once $_CONF['path'].'plugins/privacy/sql/privacy_config_data.php';

        foreach ( $privacyConfigData AS $cfgItem ) {
            $c->add(
                $cfgItem['name'],
                $cfgItem['default_value'],
                $cfgItem['type'],
                $cfgItem['subgroup'],
                $cfgItem['fieldset'],
                $cfgItem['selection_array'],
                $cfgItem['sort'],
                $cfgItem['set'],
                $cfgItem['group']
            );
        }
     }
     return true;
}
?>
