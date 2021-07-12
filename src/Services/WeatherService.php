<?php

namespace Drupal\weather\Services;

use \GuzzleHttp\Client;
use \Drupal\Core\Config\ConfigFactory;

/**
 * Class WeatherService
 *
 * @package \Drupal\weather\Services
 */
class WeatherService {

  /**
   * The Guzzle Http Client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * WeatherService constructor.
   *
   * @param \GuzzleHttp\Client $http_client
   * The Guzzle client.
   *
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   * The configuration factory.
   *
   */
  public function __construct(Client $http_client, ConfigFactory $configFactory) {
    $this->httpClient = $http_client;
    $this->configFactory = $configFactory;
  }

  /**
   * Gets the JSON from the OpenWeatherMap API and converts it to an object
   *
   * @return object
   * The weather data object.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   * The Guzzle exception.
   */
  public function getServiceData() {
    $config = $this->configFactory->get('weather.settings');

    $zip_code = 0;
    if (!empty($config->get('zip_code'))) {
      $zip_code = $config->get('zip_code');
    }

    $country_code = '';
    if (!empty($config->get('country_code'))) {
      $country_code = $config->get('country_code');
    }    

    $appid = '';
    if (!empty($config->get('appid'))) {
      $appid = $config->get('appid');
    }

    $url = 'https://api.openweathermap.org/data/2.5/weather?zip=' . $zip_code . ',' . $country_code . '&appid=' . $appid . '&units=metric';
    $response = $this->httpClient->request('GET', $url, ['verify' => FALSE]);
    $response = $response->getBody();
    $data = json_decode($response);

    return $data;
  }

}
