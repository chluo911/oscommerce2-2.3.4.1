<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class securityCheck_file_uploads
  {
      public $type = 'warning';

      public function securityCheck_file_uploads()
      {
          global $language;

          include(DIR_FS_ADMIN . 'includes/languages/' . $language . '/modules/security_check/file_uploads.php');
      }

      public function pass()
      {
          return (bool)ini_get('file_uploads');
      }

      public function getMessage()
      {
          return WARNING_FILE_UPLOADS_DISABLED;
      }
  }
