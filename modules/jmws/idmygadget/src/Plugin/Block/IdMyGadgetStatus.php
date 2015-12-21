<?php

namespace Drupal\idmygadget\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\idmygadget\GadgetDetector;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on hugability status.
 *
 * @Block(
 *   id = "idmygadget_status",
 *   admin_label = @Translation("IdMyGadget status"),
 *   category = @Translation("System")
 * )
 */
class IdMyGadgetStatus extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\idmygadget\GadgetDetector
   */
  protected $gadgetDetector;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, GadgetDetector $gadgetDetector) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->gadgetDetector = $gadgetDetector;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('idmygadget.gadget_detector')
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

  public function build() {
    if ($this->configuration['enabled']) {
      $message = $this->t('@to was the last person hugged', [
        '@to' => $this->gadgetDetector->getLastRecipient()
      ]);
    }
    else {
      $message = $this->t('No hugs :-(');
    }
    return [
      '#markup' => $message,
    ];
  }
}
