<?php
namespace Drupal\idmygadget\JmwsIdMyGadget {

  /**
   * GetJmwsIdMyGadgetDrupal is analogous to GoGlobal/NamespacedService.php in
   *   the jmws_drupal_hello_world-my_hugs-D8 repo.
   * If you think this is a hack you may want to check out that repo before judging,
   *   it is evidence that I tried many things before deciding on this technique.
   * Admitedly much of this is due to the fact that, for the other CMSes (WP and Joomla)
   *   it was copacetic (if not a requirement) to use a global object (albeit uniquely-named, duh!)
   *   to encapsulate the device detection functionality.
   * Please forgive my whining but this Symfony service and namespace stuff is all rather new
   *   (and at this time unique to Drupal).  Note to self: do Drupal first next time! ;-)
   *
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
      // error_log( 'GetJmwsIdMyGadgetDrupal constructor: $gadgetDetectorIndex = "' . $gadgetDetectorIndex . '"' );
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
// ************************************************
// ** NOTE: this code is in the global namespace **
// ************************************************
// It should be run only once, when the class above is instantiated.
// Note to self:
//   Next time we decide to do the same project in these three CMSes, do the Drupal version first,
//      because the resultant code will be better organized from the get-go!
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
      // error_log( 'global fcn createSetAndGetJmwsIdMyGadget: $gadgetDetectorString "' . $gadgetDetectorString . '"' );
    }

    return $jmwsIdMyGadget;
  }
}