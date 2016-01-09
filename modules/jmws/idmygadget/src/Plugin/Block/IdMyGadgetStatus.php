<?php
namespace Drupal\idmygadget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\idmygadget\IdMyGadgetService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on idmygadget status.
 * This code is heavily inspired by Larry Garfield's Hugs module, presented at the
 * Drupal Con in LA in 2015.
 * Also see the my_hugs module in the jmws_drupal_hello_world-my_hugs-d8 repo
 *
 * @Block(
 *   id = "idmygadget_status",
 *   admin_label = @Translation("IdMyGadget status"),
 *   category = @Translation("System")
 * )
 */
class IdMyGadgetStatus extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\idmygadget\IdMyGadgetService
   */
  protected $idMyGadgetService = null;
  /**
   * The IdMyGadget object.  It encasulates all device detection capabilities in
   * a single global (for now) object, which we can access in this class via this data member.
   *
   * @var type JmwsIdMyGadgetDrupal
   */
  protected $jmwsIdMyGadget = null;

  /**
   * Creates an instance of this class, should be called via create()
   *
   * @param array $configuration
   * @param type $plugin_id
   * @param type $plugin_definition
   * @param IdMyGadgetService $idMyGadgetService
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, IdMyGadgetService $idMyGadgetService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->idMyGadgetService = $idMyGadgetService;
    $this->jmwsIdMyGadget = $this->idMyGadgetService->jmwsIdMyGadget;
  }

  /**
   * Returns an instance of this class, calling the constructor with appropriate arguments
   *
   * @param ContainerInterface $container
   * @param array $configuration
   * @param type $plugin_id
   * @param type $plugin_definition
   * @return \static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('idmygadget.idmygadget_service')
    );
  }

  /**
   * Default configuration for enabling module (via Extend screen in back end)
   *
   * @return type
   */
  public function defaultConfiguration() {
    return ['enabled' => 1];
  }

  /**
   * Set the form for enabling module (via Extend screen in back end)
   *
   * @param type $form
   * @param FormStateInterface $form_state
   * @return type
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('IdMyGadget enabled'),
      '#default_value' => $this->configuration['enabled'],
    ];

    return $form;
  }

  /**
   * Submit the form for enabling module (via Extend screen in back end)
   *
   * @param type $form
   * @param FormStateInterface $form_state
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = (bool)$form_state->getValue('enabled');
  }

  /**
   * Returns a render array with the block markup.
   * @return type
   */
  public function build() {
    if ($this->configuration['enabled']) {
      // $sanityCheckString = $this->jmwsIdMyGadget->getSanityCheckString();
      // $message = $this->t( $sanityCheckString );
      $sanityCheckText = $this->jmwsIdMyGadget->getSanityCheckText();
      $message = $this->t( $sanityCheckText );
    }
    else {
      $message = $this->t('This module is not enabled.');
    }

    return [ '#markup' => $message, ];
  }
}
