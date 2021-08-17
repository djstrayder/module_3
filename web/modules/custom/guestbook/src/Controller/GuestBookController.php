<?php

namespace Drupal\guestbook\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GuestBookController.
 *
 * \Drupal\guestbook\Controller\GuestBookController.
 */
class GuestBookController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  protected $formBuild;

  /**
   * {@inheritdoc}
   */
  protected $entityBuild;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->formBuild = $container->get('entity.form_builder');
    $instance->entityBuild = $container->get('entity_type.manager');
    return $instance;
  }

  /**
   * Building the form.
   */
  public function buildForm() {
    $entity = $this->entityBuild
      ->getStorage('guestbook')
      ->create([
        'entity_type' => 'node',
        'entity' => 'guestbook',
      ]);
    $guestBookForm = $this->formBuild->getForm($entity, 'add');
    return $guestBookForm;
  }

  /**
   * Data for table.
   */
  public function dataGuestBook() {
    $buildForm = $this->buildForm();
    $query = \Drupal::database();
    $result = $query->select('guestbook', 'b')
      ->fields('b', [
        'id',
        'name',
        'email',
        'telephone',
        'message',
        'avatar__target_id',
        'image__target_id',
        'timestamp',
      ])
      ->orderBy('timestamp', 'DESC')
      ->execute()->fetchAll();
    $data = [];
    foreach ($result as $row) {
      $file_avatar = File::load($row->avatar__target_id);
      if (is_null($file_avatar)) {
        $row->avatar__target_id = '';
        $avatar_variables = [
          '#theme' => 'image',
          '#uri' => '/modules/custom/guestbook/files/default_user.png',
          '#width' => 100,
        ];
      }
      else {
        $avatar_uri = $file_avatar->getFileUri();
        $avatar_variables = [
          '#theme' => 'image',
          "#uri" => $avatar_uri,
          '#alt' => 'Profile avatar',
          '#title' => 'Profile avatar',
          '#width' => 100,
        ];
      }
      $file_image = File::load($row->image__target_id);
      if (!isset($file_image)) {
        $row->image__target_id = '';
        $image_variables = [
          '#theme' => 'image',
          '#uri' => 'empty_image',
          '#width' => 100,
        ];
      }
      else {
        $uri = $file_image->getFileUri();
        $uri = file_create_url($uri);
        $image_variables = [
          '#theme' => 'image',
          '#uri' => $uri,
          '#alt' => 'Feedback image',
          '#title' => 'Feedback image',
          '#width' => 200,
        ];
      }
      $data[] = [
        'name' => $row->name,
        'email' => $row->email,
        'telephone' => $row->telephone,
        'message' => $row->message,
        'avatar' => [
          'data' => $avatar_variables,
        ],
        'image' => [
          'data' => $image_variables,
        ],
        'timestamp' => $row->timestamp,
        'id' => $row->id,
        'edit' => t('Edit'),
        'delete' => t('Delete'),
        'uri' => isset($uri) ? $uri : '',
      ];
    }
    // Render page.
    return [
      'form' => $buildForm,
      'guests' => [
        '#theme' => 'guestbook-theme',
        '#rows' => $data,
      ],
    ];
  }

}
