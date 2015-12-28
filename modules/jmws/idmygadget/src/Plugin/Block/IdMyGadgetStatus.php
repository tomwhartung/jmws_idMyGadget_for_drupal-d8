<?php

namespace Drupal\idmygadget\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\idmygadget\IdMyGadgetService;
use Drupal\idmygadget\JmwsIdMyGadget;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on idmygadget status.
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

  public function __construct(array $configuration, $plugin_id, $plugin_definition, IdMyGadgetService $idMyGadgetService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->idMyGadgetService = $idMyGadgetService;
    $this->jmwsIdMyGadget = $this->idMyGadgetService->jmwsIdMyGadget;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('idmygadget.idmygadget_service')
    );
  }

  public function defaultConfiguration() {
    return ['enabled' => 1];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('IdMyGadget enabled'),
      '#default_value' => $this->configuration['enabled'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = (bool)$form_state->getValue('enabled');
  }

  /**
   * Returns a render array with the block markup.
   * @return type
   */
  public function build() {
    if ($this->configuration['enabled']) {
      $sanityCheckString = $this->jmwsIdMyGadget->getSanityCheckString();
      $message = $this->t( $sanityCheckString );
    }
    else {
      $message = $this->t('This module is not enabled.');
    }

    return [ '#markup' => $message, ];
  }
}
