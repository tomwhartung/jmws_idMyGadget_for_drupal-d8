<?php
namespace Drupal\idmygadget\JmwsIdMyGadget {

  /** GetJmwsIdMyGadgetDrupal is analogous to GoGlobal/NamespacedService.php in
   *  the jmws_drupal_hello_world-my_hugs-D8 repo.
   * This class is key in that it creates a jmwsIdMyGadget global object,
   *  like the one we use in WP and Joomla, and makes it available via the Drupal service class.
   *
   */
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
// This is where we create the jmwsIdMyGadget object, which is global (as it is in WP and Joomla)
//
namespace {
  global $jmwsIdMyGadget;
  require_once 'JmwsIdMyGadgetDrupal.php';
  $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal( 'tera_wurfl' );
  $supportedGadgetDetectors = $jmwsIdMyGadget->getSupportedGadgetDetectors();
  error_log( 'Global namespace in GetJmwsIdMyGadgetDrupal.php: $supportedGadgetDetectors[0] = ' . $supportedGadgetDetectors[0] );

}
