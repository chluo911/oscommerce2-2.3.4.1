<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class nochex
  {
      public $code;
      public $title;
      public $description;
      public $enabled;

      // class constructor
      public function nochex()
      {
          global $order;

          $this->code = 'nochex';
          $this->title = MODULE_PAYMENT_NOCHEX_TEXT_TITLE;
          $this->description = MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION;
          $this->sort_order = MODULE_PAYMENT_NOCHEX_SORT_ORDER;
          $this->enabled = ((MODULE_PAYMENT_NOCHEX_STATUS == 'True') ? true : false);

          if ((int)MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID > 0) {
              $this->order_status = MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID;
          }

          if (is_object($order)) {
              $this->update_status();
          }

          $this->form_action_url = 'https://www.nochex.com/nochex.dll/checkout';
      }

      // class methods
      public function update_status()
      {
          global $order;

          if (($this->enabled == true) && ((int)MODULE_PAYMENT_NOCHEX_ZONE > 0)) {
              $check_flag = false;
              $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOCHEX_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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

      public function javascript_validation()
      {
          return false;
      }

      public function selection()
      {
          return array('id' => $this->code,
                   'module' => $this->title);
      }

      public function pre_confirmation_check()
      {
          return false;
      }

      public function confirmation()
      {
          return false;
      }

      public function process_button()
      {
          global $order, $currencies, $customer_id;

          $process_button_string = tep_draw_hidden_field('cmd', '_xclick') .
                               tep_draw_hidden_field('email', MODULE_PAYMENT_NOCHEX_ID) .
                               tep_draw_hidden_field('amount', number_format($order->info['total'] * $currencies->currencies['GBP']['value'], $currencies->currencies['GBP']['decimal_places'])) .
                               tep_draw_hidden_field('ordernumber', $customer_id . '-' . date('Ymdhis')) .
                               tep_draw_hidden_field('returnurl', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                               tep_draw_hidden_field('cancel_return', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

          return $process_button_string;
      }

      public function before_process()
      {
          return false;
      }

      public function after_process()
      {
          return false;
      }

      public function output_error()
      {
          return false;
      }

      public function check()
      {
          if (!isset($this->_check)) {
              $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOCHEX_STATUS'");
              $this->_check = tep_db_num_rows($check_query);
          }
          return $this->_check;
      }

      public function install()
      {
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable NOCHEX Module', 'MODULE_PAYMENT_NOCHEX_STATUS', 'True', 'Do you want to accept NOCHEX payments?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('E-Mail Address', 'MODULE_PAYMENT_NOCHEX_ID', 'you@yourbuisness.com', 'The e-mail address to use for the NOCHEX service', '6', '4', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_NOCHEX_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      }

      public function remove()
      {
          tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
      }

      public function keys()
      {
          return array('MODULE_PAYMENT_NOCHEX_STATUS', 'MODULE_PAYMENT_NOCHEX_ID', 'MODULE_PAYMENT_NOCHEX_ZONE', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER');
      }
  }
