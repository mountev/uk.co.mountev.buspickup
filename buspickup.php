<?php

require_once 'buspickup.civix.php';
use CRM_Buspickup_ExtensionUtil as E;
use CRM_Buspickup_Utils as BP;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function buspickup_civicrm_config(&$config) {
  _buspickup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function buspickup_civicrm_xmlMenu(&$files) {
  _buspickup_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function buspickup_civicrm_install() {
  _buspickup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function buspickup_civicrm_postInstall() {
  _buspickup_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function buspickup_civicrm_uninstall() {
  _buspickup_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function buspickup_civicrm_enable() {
  _buspickup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function buspickup_civicrm_disable() {
  _buspickup_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function buspickup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _buspickup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function buspickup_civicrm_managed(&$entities) {
  _buspickup_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function buspickup_civicrm_caseTypes(&$caseTypes) {
  _buspickup_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function buspickup_civicrm_angularModules(&$angularModules) {
  _buspickup_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function buspickup_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _buspickup_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function buspickup_civicrm_entityTypes(&$entityTypes) {
  _buspickup_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function buspickup_civicrm_themes(&$themes) {
  _buspickup_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function buspickup_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
 */
function buspickup_civicrm_navigationMenu(&$menu) {
  _buspickup_civix_insert_navigation_menu($menu, 'Administer/System Settings', array(
    'label' => E::ts('Bus Pickup Locations'),
    'name' => 'buspickup_locations',
    'url' => CRM_Utils_System::url('civicrm/buspickup/locations', 'reset=1'),
    'permission' => 'administer CiviCRM',
    //'operator' => 'OR',
    'separator' => 0,
  ));
  _buspickup_civix_navigationMenu($menu);
}


function buspickup_civicrm_custom( $op, $groupID, $entityID, &$params ) {
  if ( $op != 'create' && $op != 'edit' ) {
    return;
  }
  if ($groupID == BP::CUSTOM_GROUP_IND_DETAILS_ID) { // Individual Details
    BP::updatePickupTime($entityID);
  }
}

function buspickup_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if (in_array($op, ['create', 'edit']) && ($objectName == 'Individual') && $objectId) {
    BP::updatePickupTime($objectId);
  }
}
