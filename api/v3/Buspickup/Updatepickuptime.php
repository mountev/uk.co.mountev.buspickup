<?php
use CRM_Buspickup_ExtensionUtil as E;
use CRM_Buspickup_Utils as BP;

/**
 * Buspickup.Updatepickuptime API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_buspickup_Updatepickuptime($params) {
  BP::updatePickupTime();
  // ALTERNATIVE: $returnValues = array(); // OK, success
  // ALTERNATIVE: $returnValues = array("Some value"); // OK, return a single value

  // Spec: civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL)
  return civicrm_api3_create_success($values = 1, $params, 'Buspickup', 'Updatepickuptime');
}
