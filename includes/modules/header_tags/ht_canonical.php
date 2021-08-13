<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class ht_canonical
  {
      public $code = 'ht_canonical';
      public $group = 'header_tags';
      public $title;
      public $description;
      public $sort_order;
      public $enabled = false;

      public function ht_canonical()
      {
          $this->title = MODULE_HEADER_TAGS_CANONICAL_TITLE;
          $this->description = MODULE_HEADER_TAGS_CANONICAL_DESCRIPTION;

          if (defined('MODULE_HEADER_TAGS_CANONICAL_STATUS')) {
              $this->sort_order = MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER;
              $this->enabled = (MODULE_HEADER_TAGS_CANONICAL_STATUS == 'True');
          }
      }

      public function execute()
      {
          global $PHP_SELF, $HTTP_GET_VARS, $cPath, $oscTemplate;

          if (basename($PHP_SELF) == FILENAME_PRODUCT_INFO) {
              $oscTemplate->addBlock('<link rel="canonical" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$HTTP_GET_VARS['products_id'], 'NONSSL', false) . '" />' . "\n", $this->group);
          } elseif (basename($PHP_SELF) == FILENAME_DEFAULT) {
              if (isset($cPath) && tep_not_null($cPath)) {
                  $oscTemplate->addBlock('<link rel="canonical" href="' . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath, 'NONSSL', false) . '" />' . "\n", $this->group);
              } elseif (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
                  $oscTemplate->addBlock('<link rel="canonical" href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . (int)$HTTP_GET_VARS['manufacturers_id'], 'NONSSL', false) . '" />' . "\n", $this->group);
              }
          }
      }

      public function isEnabled()
      {
          return $this->enabled;
      }

      public function check()
      {
          return defined('MODULE_HEADER_TAGS_CANONICAL_STATUS');
      }

      public function install()
      {
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Canonical Module', 'MODULE_HEADER_TAGS_CANONICAL_STATUS', 'True', 'Do you want to enable the Canonical module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
          tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      }

      public function remove()
      {
          tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
      }

      public function keys()
      {
          return array('MODULE_HEADER_TAGS_CANONICAL_STATUS', 'MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER');
      }
  }
