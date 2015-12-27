<?php
namespace Drupal\idmygadget\JmwsIdMyGadget {

  class GetJmwsIdMyGadgetDrupal {
    public function __construct( $createdBy='' ) {
      error_log( $createdBy . ' created this GetJmwsIdMyGadgetDrupal object.' );
    }

    /**
     * Returns the global service object created in the non-namespaced code below
     * @global type $jmwsIdMyGadget
     * @return type
     */
    public function getJmwsIdMyGadget() {
      global $jmwsIdMyGadget;
      return $jmwsIdMyGadget;
    }
  }
}
//
// This code is in the global namespace
//
namespace {
  global $jmwsIdMyGadget;
  require_once 'JmwsIdMyGadgetDrupal.php';
  $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal( 'tera_wurfl' );
}
