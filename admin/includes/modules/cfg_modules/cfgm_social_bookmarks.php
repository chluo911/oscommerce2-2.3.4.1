<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class cfgm_social_bookmarks
  {
      public $code = 'social_bookmarks';
      public $directory;
      public $language_directory = DIR_FS_CATALOG_LANGUAGES;
      public $key = 'MODULE_SOCIAL_BOOKMARKS_INSTALLED';
      public $title;
      public $template_integration = false;

      public function cfgm_social_bookmarks()
      {
          $this->directory = DIR_FS_CATALOG_MODULES . 'social_bookmarks/';
          $this->title = MODULE_CFG_MODULE_SOCIAL_BOOKMARKS_TITLE;
      }
  }
