<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  class oscTemplate
  {
      public $_title;
      public $_blocks = array();
      public $_content = array();
      public $_grid_container_width = 24;
      public $_grid_content_width = 16;
      public $_grid_column_width = 4;
      public $_data = array();

      public function oscTemplate()
      {
          $this->_title = TITLE;
      }

      public function setGridContainerWidth($width)
      {
          $this->_grid_container_width = $width;
      }

      public function getGridContainerWidth()
      {
          return $this->_grid_container_width;
      }

      public function setGridContentWidth($width)
      {
          $this->_grid_content_width = $width;
      }

      public function getGridContentWidth()
      {
          return $this->_grid_content_width;
      }

      public function setGridColumnWidth($width)
      {
          $this->_grid_column_width = $width;
      }

      public function getGridColumnWidth()
      {
          return $this->_grid_column_width;
      }

      public function setTitle($title)
      {
          $this->_title = $title;
      }

      public function getTitle()
      {
          return $this->_title;
      }

      public function addBlock($block, $group)
      {
          $this->_blocks[$group][] = $block;
      }

      public function hasBlocks($group)
      {
          return (isset($this->_blocks[$group]) && !empty($this->_blocks[$group]));
      }

      public function getBlocks($group)
      {
          if ($this->hasBlocks($group)) {
              return implode("\n", $this->_blocks[$group]);
          }
      }

      public function buildBlocks()
      {
          global $language;

          if (defined('TEMPLATE_BLOCK_GROUPS') && tep_not_null(TEMPLATE_BLOCK_GROUPS)) {
              $tbgroups_array = explode(';', TEMPLATE_BLOCK_GROUPS);

              foreach ($tbgroups_array as $group) {
                  $module_key = 'MODULE_' . strtoupper($group) . '_INSTALLED';

                  if (defined($module_key) && tep_not_null(constant($module_key))) {
                      $modules_array = explode(';', constant($module_key));

                      foreach ($modules_array as $module) {
                          $class = substr($module, 0, strrpos($module, '.'));

                          if (!class_exists($class)) {
                              if (file_exists(DIR_WS_LANGUAGES . $language . '/modules/' . $group . '/' . $module)) {
                                  include(DIR_WS_LANGUAGES . $language . '/modules/' . $group . '/' . $module);
                              }

                              if (file_exists(DIR_WS_MODULES . $group . '/' . $class . '.php')) {
                                  include(DIR_WS_MODULES . $group . '/' . $class . '.php');
                              }
                          }

                          if (class_exists($class)) {
                              $mb = new $class();

                              if ($mb->isEnabled()) {
                                  $mb->execute();
                              }
                          }
                      }
                  }
              }
          }
      }

      public function addContent($content, $group)
      {
          $this->_content[$group][] = $content;
      }

      public function hasContent($group)
      {
          return (isset($this->_content[$group]) && !empty($this->_content[$group]));
      }

      public function getContent($group)
      {
          global $language;

          if (!class_exists('tp_' . $group) && file_exists(DIR_WS_MODULES . 'pages/tp_' . $group . '.php')) {
              include(DIR_WS_MODULES . 'pages/tp_' . $group . '.php');
          }

          if (class_exists('tp_' . $group)) {
              $template_page_class = 'tp_' . $group;
              $template_page = new $template_page_class();
              $template_page->prepare();
          }

          foreach ($this->getContentModules($group) as $module) {
              if (!class_exists($module)) {
                  if (file_exists(DIR_WS_MODULES . 'content/' . $group . '/' . $module . '.php')) {
                      if (file_exists(DIR_WS_LANGUAGES . $language . '/modules/content/' . $group . '/' . $module . '.php')) {
                          include(DIR_WS_LANGUAGES . $language . '/modules/content/' . $group . '/' . $module . '.php');
                      }

                      include(DIR_WS_MODULES . 'content/' . $group . '/' . $module . '.php');
                  }
              }

              if (class_exists($module)) {
                  $mb = new $module();

                  if ($mb->isEnabled()) {
                      $mb->execute();
                  }
              }
          }

          if (class_exists('tp_' . $group)) {
              $template_page->build();
          }

          if ($this->hasContent($group)) {
              return implode("\n", $this->_content[$group]);
          }
      }

      public function getContentModules($group)
      {
          $result = array();

          foreach (explode(';', MODULE_CONTENT_INSTALLED) as $m) {
              $module = explode('/', $m, 2);

              if ($module[0] == $group) {
                  $result[] = $module[1];
              }
          }

          return $result;
      }
  }
