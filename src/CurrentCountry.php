<?php

namespace Drupal\country;

/**
 * Class CurrentCountry.
 *
 * @package Drupal\country
 */
class CurrentCountry implements CurrentCountryInterface {

  /**
   * {@inheritdoc}
   */
  public function getSlug() {
    $request_path = \Drupal::request()->getPathInfo();
    $path_info = explode('/', $request_path);
    $slug = $path_info[1];

    // Only allow a 2 character slug.
    return strlen($slug) == 2 ? $slug : '';
  }

}
