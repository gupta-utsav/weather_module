<?php
/**
 * @file
 * Contains \Drupal\weather\Controller\WeatherController.
 */

namespace Drupal\weather\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Drupal\weather\Services\WeatherService;
use \Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WeatherController
 *
 * @package Drupal\weather\Controller
 */
class WeatherController extends ControllerBase {

  /**
   * The weather service.
   *
   * @var \Drupal\weather\Services\WeatherService
   */
  private $weatherService;

  /**
   * WeatherController constructor.
   *
   * @param \Drupal\weather\Services\WeatherService $weather_service
   * The weather service.
   */
  public function __construct(WeatherService $weather_service) {
    $this->weatherService = $weather_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $weatherService = $container->get('weather.weather_services');
    return new static($weatherService);
  }

  /**
   * Gets weather data and passes it to the module.
   *
   * @return array
   * The weather data array.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   * The Guzzle exception.
   */
  public function content() {
    $weather_data = $this->weatherService->getServiceData();
    return [
      '#theme' => 'weather',
      '#weather_data' => $weather_data,
    ];
  }

}
