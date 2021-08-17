<?php

namespace Drupal\strayder\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\file\FileInterface;
use Drupal\file\Entity\File;

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
 *       "add" = "Drupal\strayder\Form\GuestbookForm",
 *       "edit" = "Drupal\strayder\Form\GuestbookFrom",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "permission_provider" = "Drupal\Core\Entity\EntityPermissionProvider",
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gb",
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
      ->setRequired(FALSE)
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
        'alt_field_required' => FALSE,
      ]);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel('ADDING A PICTURE TO THE REVIEW:')
      ->setDescription('ONLY PNG, JPEG, JPG AND < 5MB')
      ->setRequired(FALSE)
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
        'alt_field_required' => FALSE,
      ]);

    $fields['timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel('Date')
      ->setRequired(TRUE);

    return $fields;
  }

  /**
   * Return name.
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * Return email.
   */
  public function getEmail() {
    return $this->get('email')->value;
  }

  /**
   * Return telephone.
   */
  public function getTelephone() {
    return $this->get('telephone')->value;
  }

  /**
   * Return message.
   */
  public function getMessage() {
    return $this->get('message')->value;
  }

  /**
   * Return avatar.
   */
  public function getAvatar() {
    $avatar = [];
    $avatarId = $this->get('avatar')->target_id;
    if (isset($avatarId)) {
      $avatarFile = File::load($avatarId);
      if ($avatarFile instanceof FileInterface) {
        $avatar = [
          '#type' => 'image',
          '#uri' => $avatarFile->getFileUri(),
          '#width' => 100,
        ];
        $renderer = \Drupal::service('renderer');
        $avatar = $renderer->render($avatar);
      }
    }
    else {
      $avatar = '{no avatar}';
    }
    return $avatar;
  }

  /**
   * Return image.
   */
  public function getImage() {
    $image = [];
    $imageId = $this->get('image')->target_id;
    if (isset($imageId)) {
      $imageFile = File::load($imageId);
      if ($imageFile instanceof FileInterface) {
        $image = [
          '#type' => 'image',
          '#uri' => $imageFile->getFileUri(),
          '#width' => 200,
        ];
        $renderer = \Drupal::service('renderer');
        $image = $renderer->render($image);
      }
    }
    else {
      $image = '{no image}';
    }
    return $image;
  }

  /**
   * Return data.
   */
  public function getTimestamp() {
    return $this->get('timestamp')->value;
  }

}
