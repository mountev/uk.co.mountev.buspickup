<?php

use CRM_Buspickup_ExtensionUtil as E;
use CRM_Buspickup_Utils as BP;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Buspickup_Form_Locations extends CRM_Core_Form {

  /**
   * Build all the data structures needed to build the form.
   */
  public function preProcess() {
    $this->_action = CRM_Core_Action::VIEW;
    if (CRM_Core_Permission::check('administer CiviCRM')) {
      $this->_action = CRM_Core_Action::UPDATE;
    }
    CRM_Core_Resources::singleton()->addStyleFile('uk.co.mountev.buspickup',  'css/spin.css', 10, 'html-header');
    CRM_Core_Resources::singleton()->addScriptFile('uk.co.mountev.buspickup', 'js/modernizr.js', 20, 'html-header', FALSE);
    CRM_Core_Resources::singleton()->addScriptFile('uk.co.mountev.buspickup', 'js/spinner.js', 500, 'html-header', FALSE);
  }

  public function buildQuickForm() {
    if ($this->_action == CRM_Core_Action::UPDATE) {
      $busPickupCFId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', 'Bus_Pickup_Point', 'id', 'name');
      $locations = ['' => ' - ' . ts('location') . ' - '] + CRM_Core_PseudoConstant::get('CRM_Core_BAO_CustomField', 'custom_' . $busPickupCFId, [], 'create');
      $this->_rowCount = (count($locations) <= 10) ? 10 : (count($locations)+1);
      $this->assign('rowCount', $this->_rowCount);

      for ($i = 1; $i <= $this->_rowCount; $i++) { 
        $this->add('select', "location[$i]", ts('Location'), $locations, FALSE, ['class' => 'crm-select2 huge']);
        $this->add('text', "k2b_time[$i]", ts('K2B Walkers'));
        $this->add('text', "c2b_time[$i]", ts('C2B Walkers'));
        $this->add('text', "k2b_map[$i]", ts('K2B Map URL'), ['size' => '40']);
        $this->add('text', "c2b_map[$i]", ts('C2B Map URL'), ['size' => '40']);
      }

      $this->addButtons(array(
        array(
          'type' => 'submit',
          'name' => E::ts('Save'),
          'isDefault' => TRUE,
        ),
      ));
    }
    parent::buildQuickForm();
  }

  /**
   * Set default values.
   *
   * @return array
   */
  public function setDefaultValues() {
    $defaults = BP::getData($this->_action);
    CRM_Core_Error::debug_var('$defaults', $defaults);
    if ($this->_action == CRM_Core_Action::VIEW) {
      $this->assign('rows', $defaults);
    }
    return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    CRM_Core_Error::debug_var('$values', $values);
    if (BP::store($values, $this->_rowCount)) {
      CRM_Core_Session::setStatus(ts('Locations have been saved.'), ts('Success'), 'success');
    }
    parent::postProcess();
  }

}
