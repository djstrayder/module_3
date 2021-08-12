<?php

namespace Drupal\guest_book\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the str entity class.
 *
 * @ContentEntityType(
 *   id = "guest_book",
 *   label = @Translation("guest_book"),
 *   label_collection = @Translation("guest_books"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\guest_book\GuestbookListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\guest_book\Form\GuestBookForm",
 *       "edit" = "Drupal\guest_book\Form\GuestBookFrom",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "permission_provider" = "Drupal\Core\Entity\EntityPermissionProvider",
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "guest_book",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/guest_book/add",
 *     "canonical" = "/guest_book/add",
 *     "edit-form" = "/guest_book/{guest_book}/edit",
 *     "delete-form" = "/guest_book/{guest_book}/delete"
 *   },
 *   admin_permission = "administer nodes",
 * )
 */
class Guestbook extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    //receiving fields from parents
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setTargetBundle(TRUE)
      ->setLabel('Name')
      ->setDescription('minimum length 2, maximum length 100')
      ->setRequired(TRUE)
      ->setSetting('max_length', 100)
      ->setSetting('min_length', 2)
      ->setDisplayOptions('form',[
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('string');
    $fields['telephone'] = BaseFieldDefinition::create('email');
    $fields['message'] = BaseFieldDefinition::create('string_long');
    $fields['avatar'] = BaseFieldDefinition::create('image');
    $fields['image'] = BaseFieldDefinition::create('image');
    $fields['timestamp'] = BaseFieldDefinition::create('created');



    return $fields;
  }
}

