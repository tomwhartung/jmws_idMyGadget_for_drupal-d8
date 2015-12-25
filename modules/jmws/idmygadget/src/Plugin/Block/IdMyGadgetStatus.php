<?php

namespace Drupal\idmygadget\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\idmygadget\GadgetDetector;
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
      // $message = $this->t('@to was the last person hugged', [
      //   '@to' => $this->gadgetDetector->getLastRecipient()
      // ]);
      $message = $this->t('Using the @gadget_detector detector for device detection', [
        '@gadget_detector' => $this->gadgetDetector->getGadgetDetector()
      ]);
    }
    else {
      $message = $this->t('This module is not enabled.');
    }

	// $jmwsIdMyGadget = new \Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $jmwsIdMyGadget = new Drupal\idmygadget\JmwsIdMyGadget\JmwsIdMyGadgetDrupal();
	// $jmwsIdMyGadget = new JmwsIdMyGadgetDrupal();

	if ( class_exists('JmwsIdMyGadgetDrupal') ) {
		$message .= '  Yes and btw JmwsIdMyGadgetDrupal is a class!';
	}
	else {
		$message .= '  Oops and sowwy JmwsIdMyGadgetDrupal is a NOT class!';
	}
    return [
      '#markup' => $message,
    ];
  }
}
