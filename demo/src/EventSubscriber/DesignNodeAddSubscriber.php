<?php

namespace Drupal\demo\EventSubscriber;

use Drupal\demo\Event\DesignNodeAddEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Logs the creation of a new node.
 */
class DesignNodeAddSubscriber implements EventSubscriberInterface {


  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Log the creation of a new node.
   *
   * @param \Drupal\demo\Event\DesignNodeAddEvent $event
   */
  public function onDesignNodeInsert(DesignNodeAddEvent $event) {
    $entity = $event->getEntity();
    $this->saveDesign($entity->id(), $entity->get('field_designer_s_credit')->getValue()[0]['value']);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[DesignNodeAddEvent::DESIGN_NODE_INSERT][] = ['onDesignNodeInsert'];
    return $events;
  }

  /**
   * Save the given Design Node into a custom field name design_list
   *
   * @param int $nid
   *   The  node ID to be saved.
   * @param string $designCredits
   *   The contents of the design Credits Field.
   */
  private function saveDesign($Nid, $designCredits) {
    $database = \Drupal::database();

    $database->insert('design_list')
      ->fields([
        'nid' => $Nid,
        'designer_credits' => $designCredits,

      ])
      ->execute();

  }

}
