<?php
namespace Drupal\idmygadget\JmwsIdMyGadget {

  /** GetJmwsIdMyGadgetDrupal is analogous to GoGlobal/NamespacedService.php in
   *  the jmws_drupal_hello_world-my_hugs-D8 repo.
   * This class is key in that it creates a jmwsIdMyGadget global object,
   *  like the one we use in WP and Joomla, and makes it available via the Drupal service class.
   *
   */
  class GetJmwsIdMyGadgetDrupal {
    /**
     * String representing one of the supported gadget detectors
     * e.g. 'mobile_detect'
     * @var type string
     */
    protected $gadgetDetectorIndex = 0;

    /**
     * Use the gadget detector string to construct the corresponding gadget detector type
     *
     * @param type string $gadgetDetectorIndex
     */
    public function __construct( $gadgetDetectorIndex=0 ) {
      $this->gadgetDetectorIndex = $gadgetDetectorIndex;
      error_log( 'GetJmwsIdMyGadgetDrupal constructor: $gadgetDetectorIndex = "' . $gadgetDetectorIndex . '"' );
      $this->getJmwsIdMyGadget();
    }

    /**
     * The first time this is called (from the constructor) we call the global function in the
     *   non-namespaced code below to create and set it in the global namespace, and of course return it.
     * Subsequent calls return the global service object previously created
     * @global type $jmwsIdMyGadget
     * @return type
     */
    public function getJmwsIdMyGadget() {
      global $jmwsIdMyGadget;

      if( $jmwsIdMyGadget == null ) {
        $jmwsIdMyGadget = createSetAndGetJmwsIdMyGadget( $this->gadgetDetectorIndex );
      }

      return $jmwsIdMyGadget;
    }
  }
}
//
// This code is in the global namespace
// It should be run only once, when the class above is instantiated.
//
namespace {
  require_once 'JmwsIdMyGadgetDrupal.php';
  /**
   * The global jmwsIdMyGadget object
   * As of Drupal 8, globals are a big no-no, but this is how we do it in WP and Joomla and
   *   the name should be suffficiently unique to avoid collisions.  Hopefully.
   */
  $jmwsIdMyGadget = null;
  /**
   * Create and set (first time only) and always return the jmwsIdMyGadget object,
   *   which is global (as it is in WP and Joomla).
   *
   * @global JmwsIdMyGadgetDrupal $jmwsIdMyGadget
   * @param type string $gadgetDetectorIndex
   * @return \JmwsIdMyGadgetDrupal object
   */
  function createSetAndGetJmwsIdMyGadget( $gadgetDetectorIndex=0 ) {
    global $jmwsIdMyGadget;

    if( $jmwsIdMyGadget == null ) {
      $gadgetDetectorString = JmwsIdMyGadgetDrupal::$supportedGadgetDetectors[$gadgetDetectorIndex];
      $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal( $gadgetDetectorString );
      error_log( 'global fcn createSetAndGetJmwsIdMyGadget: $gadgetDetectorString "' . $gadgetDetectorString . '"' );
    }

    return $jmwsIdMyGadget;
  }
}
