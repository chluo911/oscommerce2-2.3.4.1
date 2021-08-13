<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if (!class_exists('moneybookers')) {
      include(DIR_FS_CATALOG . 'includes/modules/payment/moneybookers.php');
  }

  class moneybookers_so2 extends moneybookers
  {
      public $code;
      public $title;
      public $description;
      public $enabled;

      public $_sid; // Moneybookers transaction session ID
      public $_mbcartID = 'cart_MoneybookersSO2_ID';
      public $_payment_method = 'SO2';
      public $_payment_method_image = 'nordea.gif';

      // class constructor
      public function moneybookers_so2()
      {
          global $order;

          $this->signature = 'moneybookers|moneybookers_so2|1.0|2.3';

          $this->code = 'moneybookers_so2';
          $this->title = MODULE_PAYMENT_MONEYBOOKERS_SO2_TEXT_TITLE;
          $this->public_title = MODULE_PAYMENT_MONEYBOOKERS_SO2_TEXT_PUBLIC_TITLE;
          $this->description = MODULE_PAYMENT_MONEYBOOKERS_SO2_TEXT_DESCRIPTION;
          $this->sort_order = MODULE_PAYMENT_MONEYBOOKERS_SO2_SORT_ORDER;
          $this->enabled = ((MODULE_PAYMENT_MONEYBOOKERS_SO2_STATUS == 'True') ? true : false);

          if ((int)MODULE_PAYMENT_MONEYBOOKERS_SO2_PREPARE_ORDER_STATUS_ID > 0) {
              $this->order_status = MODULE_PAYMENT_MONEYBOOKERS_SO2_PREPARE_ORDER_STATUS_ID;
          }

          if (is_object($order)) {
              $this->update_status();
          }

          if (defined('MODULE_PAYMENT_MONEYBOOKERS_IFRAME') && (MODULE_PAYMENT_MONEYBOOKERS_IFRAME == 'True')) {
              $this->form_action_url = tep_href_link('ext/modules/payment/moneybookers/checkout.php', '', 'SSL');
          } else {
              $this->form_action_url = 'https://www.moneybookers.com/app/payment.pl';
          }
      }

      // class methods
      public function update_status()
      {
          global $order;

          if (!defined('MODULE_PAYMENT_MONEYBOOKERS_STATUS')) {
              $this->enabled = false;
          } elseif (($this->enabled == true) && ((int)MODULE_PAYMENT_MONEYBOOKERS_SO2_ZONE > 0)) {
              $check_flag = false;
              $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_MONEYBOOKERS_SO2_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
              while ($check = tep_db_fetch_array($check_query)) {
                  if ($check['zone_id'] < 1) {
                      $check_flag = true;
                      break;
                  } elseif ($check['zone_id'] == $order->billing['zone_id']) {
                      $check_flag = true;
                      break;
                  }
              }

              if ($check_flag == false) {
                  $this->enabled = false;
              }
          }
      }

      public function confirmation()
      {
          global $language;

          include(DIR_FS_CATALOG . 'includes/languages/' . $language . '/modules/payment/moneybookers.php');

          parent::confirmation();
      }

      public function check()
      {
          if (!isset($this->_check)) {
              $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_MONEYBOOKERS_SO2_STATUS'");
              $this->_check = tep_db_num_rows($check_query);
          }
          return $this->_check;
      }

      public function install()
      {
          if (!defined('MODULE_PAYMENT_MONEYBOOKERS_STATUS')) {
              tep_redirect(tep_href_link('ext/modules/payment/moneybookers/activation.php', 'action=coreRequired'));
          }

          $zone_id = 0;

          $zone_query = tep_db_query("select geo_zone_id from " . TABLE_GEO_ZONES . " where geo_zone_name = 'Moneybookers Nordea Solo (FI)'");
          if (tep_db_num_rows($zone_query)) {
              $zone = tep_db_fetch_array($zone_query);

              $zone_id = $zone['geo_zone_id'];
          } else {
              tep_db_query("insert into " . TABLE_GEO_ZONES . " values (null, 'Moneybookers Nordea Solo (FI)', 'The zone for the Moneybookers Nordea Solo (FI) payment module', null, now())");
              $zone_id = tep_db_insert_id();

              $country_query = tep_db_query("select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_2 = 'FI'");
              if (tep_db_num_rows($country_query)) {
                  $country = tep_db_fetch_array($country_query);

                  tep_db_query("insert into " . TABLE_ZONES_TO_GEO_ZONES . " values (null, '" . (int)$country['countries_id'] . "', 0, '" . (int)$zone_id . "', null, now())");
              }
          }

          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Moneybookers Nordea Solo (FI)', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_STATUS', 'False', 'Do you want to accept Moneybookers Nordea Solo (FI) payments?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_ZONE', '" . (int)$zone_id . "', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Preparing Order Status', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_PREPARE_ORDER_STATUS_ID', '" . MODULE_PAYMENT_MONEYBOOKERS_PREPARE_ORDER_STATUS_ID . "', 'Set the status of prepared orders made with this payment module to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Transactions Order Status', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_TRANSACTIONS_ORDER_STATUS_ID', '" . MODULE_PAYMENT_MONEYBOOKERS_TRANSACTIONS_ORDER_STATUS_ID . "', 'Set the status of callback transactions to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      }

      public function keys()
      {
          return array('MODULE_PAYMENT_MONEYBOOKERS_SO2_STATUS', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_ZONE', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_PREPARE_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_TRANSACTIONS_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYBOOKERS_SO2_SORT_ORDER');
      }
  }