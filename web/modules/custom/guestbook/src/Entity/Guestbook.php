<?php

namespace Drupal\guestbook\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the str entity class.
 *
 * @ContentEntityType(
 *   id = "guestbook",
 *   label = @Translation("guestbook"),
 *   handlers = {
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "views_data" = "Drupal\Core\Views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\guestbook\Form\GuestbookForm",
 *       "edit" = "Drupal\guestbook\Form\GuestbookFrom",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "permission_provider" = "Drupal\Core\Entity\EntityPermissionProvider",
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "guestbook",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/guestbook/add",
 *     "canonical" = "/guestbook/add",
 *     "edit-form" = "/guestbook/{guestbook}/edit",
 *     "delete-form" = "/guestbook/{guestbook}/delete",
 *     "collection" = "/guestbook/list",
 *   },
 *   admin_permission = "administer nodes",
 * )
 */
class Guestbook extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Receiving fields from parents.
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setTargetBundle(TRUE)
      ->setLabel('Name')
      ->setRequired(TRUE)
      ->setSetting('max_length', 100)
      ->setSetting('min_length', 2)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
        'settings' => [
          'placeholder' => 'minimum length 2, maximum length 100',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setTargetBundle(TRUE)
      ->setLabel('Email')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'label' => 'inline',
        'weight' => 5,
        'settings' => [
          'placeholder' => 'guestbook@gmail.com',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 5,
        'settings' => [
          'placeholder' => 'guestbook@gmail.com',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['telephone'] = BaseFieldDefinition::create('string')
      ->setTargetBundle(TRUE)
      ->setLabel('Telephone')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'label' => 'inline',
        'weight' => 10,
        'settings' => [
          'placeholder' => 'like this +380997548675',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 10,
        'settings' => [
          'placeholder' => 'like this +380997548675',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setTargetBundle(TRUE)
      ->setLabel('Message')
      ->setDescription('Message')
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'label' => 'inline',
        'weight' => 15,
        'settings' => [
          'placeholder' => 'Message',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 15,
        'settings' => [
          'placeholder' => 'Message',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel('Your avatar')
      ->setDescription('ONLY PNG, JPEG, JPG AND < 2MB')
      ->setDisplayOptions('form', [
        'label' => 'inline',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setSettings([
        'max_filesize' => '2097152',
        'upload_location' => 'public://guestbook/avatars/',
        'file_extensions' => 'png jpg jpeg',
        'alt_field' => FALSE,
      ]);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel('ADDING A PICTURE TO THE REVIEW:')
      ->setDescription('ONLY PNG, JPEG, JPG AND < 5MB')
      ->setDisplayOptions('form', [
        'label' => 'inline',
        'weight' => 25,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'weight' => 25,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setSettings([
        'max_filesize' => '5242880',
        'upload_location' => 'public://guestbook/images/',
        'file_extensions' => 'png jpg jpeg',
        'alt_field' => FALSE,
      ]);

    $fields['timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel('Date')
      ->setRequired(TRUE);

    return $fields;
  }

}
