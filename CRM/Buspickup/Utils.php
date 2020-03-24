<?php

/**
 * Buspickup Utils Class
 *
 */
class CRM_Buspickup_Utils {

  const
    CUSTOM_GROUP_IND_DETAILS_ID = 2,
    EDIT_BUSPICKUP_LOCATIONS    = 'edit buspickup locations';
    
  public static function store($data, $rowCount) {
    $rowValues = [];
    for ($i = 1; $i <= $rowCount; $i++) { 
      if (!empty($data['location'][$i])) {
        foreach (array('location', 'k2b_time', 'c2b_time', 'k2b_map', 'c2b_map') as $field) {
          if (!empty($data[$field][$i])) {
            $type = ($field == 'location') ? 'Positive' : 'String';
            $data[$field][$i] = CRM_Utils_Type::escape($data[$field][$i], $type);
          }
        }
        $rowValues[] = "({$data['location'][$i]}, '{$data['k2b_time'][$i]}', '{$data['c2b_time'][$i]}', '{$data['k2b_map'][$i]}', '{$data['c2b_map'][$i]}')";
      }
    }
    if (!empty($rowValues)) {
      CRM_Core_DAO::executeQuery("TRUNCATE TABLE buspickup_locations");
      $query = "INSERT INTO buspickup_locations (`location`, `k2b_time`, `c2b_time`, `k2b_map`, `c2b_map`) VALUES " . implode(',', $rowValues);
      CRM_Core_DAO::executeQuery($query);
      return TRUE;
    }
    return FALSE;
  }

  public static function getData($action = CRM_Core_Action::UPDATE) { 
    $defaults = [];
    if ($action == CRM_Core_Action::VIEW) {
      $busPickupCFId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', 'Bus_Pickup_Point', 'id', 'name');
      $locations = CRM_Core_PseudoConstant::get('CRM_Core_BAO_CustomField', 'custom_' . $busPickupCFId, [], 'create');
    }

    $query = "SELECT * FROM buspickup_locations ORDER BY id";
    $dao   = CRM_Core_DAO::executeQuery($query);
    $i = 0;
    while ($dao->fetch()) {
      $i++;
      foreach (array('location', 'k2b_time', 'c2b_time', 'k2b_map', 'c2b_map') as $field) {
        if (!empty($dao->$field)) {
          if ($action == CRM_Core_Action::UPDATE) {
            $defaults[$field][$i] = $dao->$field;
          } else {
            // view mode 
            $defaults[$i][$field] = ($field == 'location') ? $locations[$dao->$field] : $dao->$field;
          }
        }
      }
    }
    return $defaults;
  }
  
  public static function updatePickupTime($entityID) {
    if (isset(Civi::$statics[__CLASS__]['updatebuspickuptime'])) {
      return;
    }
    Civi::$statics[__CLASS__]['updatebuspickuptime'] = TRUE;

    $tableName = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomGroup', self::CUSTOM_GROUP_IND_DETAILS_ID, 'table_name');
    $busPickupCFId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', 'Bus_Pickup_Point', 'id', 'name');
    $indResult = civicrm_api3('Contact', 'getsingle', [
      'return' => ["custom_{$busPickupCFId}"],
      'id' => $entityID,
    ]);
    if (!empty($indResult["custom_{$busPickupCFId}"])) {
      $empResult = civicrm_api3('Contact', 'getsingle', [
        'return' => ["current_employer_id"],
        'contact_id' => $entityID,
      ]);
      if (!empty($empResult['current_employer_id'])) {
        $teamTypeCFId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', 'Team_Type', 'id', 'name');
        $teamResult = civicrm_api3('Contact', 'getsingle', [
          'return' => ["custom_{$teamTypeCFId}"],
          'id' => $empResult['current_employer_id'],
        ]);
        if (!empty($teamResult["custom_{$teamTypeCFId}"])) {
          $optionValues = CRM_Core_PseudoConstant::get('CRM_Core_BAO_CustomField', 'custom_' . $teamTypeCFId, [], 'create');
          $optionValues = array_flip($optionValues);
          $time = '';
          if ($teamResult["custom_{$teamTypeCFId}"] == $optionValues['K2B']) {
            $query = "SELECT k2b_time FROM buspickup_locations WHERE location = %1 LIMIT 1";
            $time  = CRM_Core_DAO::singleValueQuery($query, [1 => [$indResult["custom_{$busPickupCFId}"], 'Positive']]);
          } else if ($teamResult["custom_{$teamTypeCFId}"] == $optionValues['C2B']) {
            $query = "SELECT c2b_time FROM buspickup_locations WHERE location = %1 LIMIT 1";
            $time  = CRM_Core_DAO::singleValueQuery($query, [1 => [$indResult["custom_{$busPickupCFId}"], 'Positive']]);
          }
          if (!empty($time)) {
            $busPickupTimeCFId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', 'Bus_Pickup_Time', 'id', 'name');
            $result = civicrm_api3('CustomValue', 'create', [
              'entity_id'  => $entityID,
              "custom_{$busPickupTimeCFId}" => $time,
            ]);
            Civi::log()->debug("Bus pickup time updated - contact: $entityID, location: {$indResult["custom_{$busPickupCFId}"]}, time: {$time}");
          }
        }
      }
    }
  }
}
