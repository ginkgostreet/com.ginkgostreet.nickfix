<?php

require_once 'nickfix.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function nickfix_civicrm_config(&$config) {
  _nickfix_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function nickfix_civicrm_install() {
  _nickfix_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function nickfix_civicrm_enable() {
  _nickfix_civix_civicrm_enable();
}

function nickfix_civicrm_pre($op, $objectName, $id, &$params) {
  if ($objectName == 'Individual' && ($op == 'create' || $op == 'edit')) {
    /* Bail if nickname is provided */
    if (!empty($params['nick_name'])) {
      return;
    }
    /* Fetch nickname if contact exists */
    $nickname = NULL;
    if (!empty($id)) {
      $nickname = civicrm_api3('Contact', 'getvalue', array(
        'return' => 'nick_name',
        'id' => $id
      ));
    }
    /* We already have a nickname for this contact */
    if (!empty($nickname)) {
      /* if nickname is provided and not an empty string; bail */
      if (array_key_exists('nick_name', $params) && !empty($params['nick_name'])) {
        return;
      }
      if (!array_key_exists('nick_name', $params)) {
        return;
      }
    }

    /* Fetch first name if not provided */
    $firstname = CRM_Utils_Array::value('first_name', $params);
    if (!empty($id) && empty($firstname)) {
      $firstname = civicrm_api3('Contact', 'getvalue', array(
        'return' => 'first_name',
        'id' => $id
      ));
    }
    $params['nick_name'] = $firstname;
  }
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 **/
/*

*/

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
**/
/*
function nickfix_civicrm_navigationMenu(&$menu) {
  _nickfix_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'org.leadercenter.nickfix')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _nickfix_civix_navigationMenu($menu);
}
*/
