<?php

namespace Drupal\country;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Class CurrentCountry.
 *
 * @package Drupal\country
 */
class CountryManager implements CountryManagerInterface {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager, QueryFactory $entity_query) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public function suggestCountry() {
    $country = NULL;

    // @todo What to base the suggested country on?
      // Country from cookie? Anything else?
    $country = $this->entityTypeManager->getStorage('country')->load(1);

    return $country;
  }

  /**
   * {@inheritdoc}
   */
  public function getLanguagesPerCountry() {
    $languages = array();
    $available = \Drupal::languageManager()->getLanguages();

    /** @var \Drupal\country\Entity\Country[] $countries */
    $countries = $this->entityTypeManager->getStorage('country')->loadByProperties(['status' => 1]);
    foreach ($countries as $country) {
      $country_languages = $country->getCountryLanguages();
      $languages[$country->getSlug()] = array_intersect_key($available, array_flip($country_languages));
    }

    return $languages;
  }

  /**
   * {@inheritdoc}
   */
  public function getRegions() {
    // @todo Check if ids are the same as (part of) the css class used for each region.
    $regions = [
      'americas' => [
        'id' => 'americas',
        'label' => $this->t('Americas'),
        'code' => 'na',
      ],
      'africa' => [
        'id' => 'africa',
        'label' => $this->t('Africa'),
        'code' => 'af',
      ],
      'middle-east' => [
        'id' => 'middle-east',
        'label' => $this->t('Middle East'),
        'code' => 'me',
      ],
      'asia-pacific' => [
        'id' => 'asia-pacific',
        'label' => $this->t('Asia Pacific'),
        'code' => 'as',
      ],
      'europe' => [
        'id' => 'europe',
        'label' => $this->t('Europe'),
        'code' => 'eu',
      ],
    ];

    return $regions;
  }

  /**
   * {@inheritdoc}
   */
  public function getCountriesPerRegion() {
    $result = array();

    $cids = $this->entityQuery->get('country')
      ->condition('status', 1)
      ->sort('name', 'ASC')
      ->execute();
    $countries = $this->entityTypeManager->getStorage('country')->loadMultiple($cids);
    foreach ($countries as $country) {
      $result[$country->field_country_region->value][$country->id()] = $country;
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function countryOptionList() {
    $list = [];

    $cids = $this->entityQuery->get('country')
      ->condition('status', 1)
      ->sort('name', 'ASC')
      ->execute();

    /** @var \Drupal\country\Entity\Country[] $countries */
    $countries = $this->entityTypeManager->getStorage('country')->loadMultiple($cids);
    foreach ($countries as $country) {
      $list[$country->getSlug()] = (string)$this->t($country->label());
    }

    return $list;
  }

}
