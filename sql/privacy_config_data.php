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

$privacyConfigData = array(
    array(
        'name' => 'sg_main',
        'default_value' => NULL,
        'type' => 'subgroup',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 0,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'pv_settings',
        'default_value' => NULL,
        'type' => 'fieldset',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 0,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'exportuser',
        'default_value' => '1',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 20,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'registrationlinks',
        'default_value' => '1',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 30,
        'set' => TRUE,
        'group' => 'privacy'
    ),
    array(
        'name' => 'privacypolicy',
        'default_value' => 'privacy-policy',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 40,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'termsofuse',
        'default_value' => 'terms-of-use',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 50,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'pv_cookie',
        'default_value' => NULL,
        'type' => 'fieldset',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => NULL,
        'sort' => 0,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'cookieconsent',
        'default_value' => '1',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => 0,
        'sort' => 10,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'cookiestyle',
        'default_value' => 'block',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => 2,
        'sort' => 20,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'cookieposition',
        'default_value' => 'bottom',
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => 1,
        'sort' => 30,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'cookietext',
        'default_value' => 'This website uses cookies to ensure you get the best experience on our website. ',
        'type' => 'text',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => 1,
        'sort' => 40,
        'set' => TRUE,
        'group' => 'privacy'
    ),

    array(
        'name' => 'cookielearnmore',
        'default_value' => 'https://cookiesandyou.com',
        'type' => 'text',
        'subgroup' => 0,
        'fieldset' => 1,
        'selection_array' => 1,
        'sort' => 50,
        'set' => TRUE,
        'group' => 'privacy'
    ),
);
?>