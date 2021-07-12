<?php

/**
 * @file
 * Contains \Drupal\weather\Form\WeatherConfigForm.
 */

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WeatherConfigForm
 *
 * @package Drupal\weather\Form
 */
class WeatherConfigForm extends ConfigFormBase {

  /**
   * WeatherConfigForm constructor.
   */
  public function __construct() {
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('weather.settings');

    $form['zip_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ZIP CODE'),
      '#default_value' => $config->get('zip_code'),
      '#required' => TRUE,
    ];

    $form['country_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('COUNTRY CODE'),
      '#default_value' => $config->get('country_code'),
      '#required' => TRUE,
    ];

    $form['appid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OpenWeatherMap API key'),
      '#default_value' => $config->get('appid'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('weather.settings');
    $config->set('zip_code', $form_state->getValue('zip_code'));
    $config->set('country_code', $form_state->getValue('country_code'));    
    $config->set('appid', $form_state->getValue('appid'));
    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'weather.settings',
    ];
  }

}
