<?php

namespace Drupal\demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for Design Listing routes.
 */
class Designs extends ControllerBase {

  protected $database;

  /**
   * @param \Drupal\Core\Database\Connection $database
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // Load the service required to construct this class.
      $container->get('database'));
  }

  /**
   * Function to display the Design Listing page.
   */
  public function listall() {
    $data =[];
    $build['#type'] = 'markup';
    $query = $this->database->select('design_list', 'dl');
    $query->fields('dl', ['nid', 'designer_credits']);
    $result = $query->execute()->fetchAll();
    foreach ($result as $key => $nodevalue) {
      $data['nid'] = $nodevalue->nid;
      $data['designer_credits'] = $nodevalue->designer_credits;
      $rows[] = $data;
    }
    $header = [
      $this->t('Node ID'),
      $this->t('Designer Credits'),
    ];

    $build['design_list'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No Designs available.'),
    ];
    return $build;

  }
}
