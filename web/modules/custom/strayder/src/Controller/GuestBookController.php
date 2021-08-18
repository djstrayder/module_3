<?php

namespace Drupal\strayder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Class GuestBookController.
 *
 * \Drupal\strayder\Controller\GuestBookController.
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
  public function load() {
    $query = Database::getConnection()->select('gb', 'b');
    $query->fields('b', [
      'id',
      'name',
      'email',
      'telephone',
      'message',
      'avatar__target_id',
      'image__target_id',
      'timestamp',
    ]);
    $result = $query
      ->execute()
      ->fetchAll();
    return $result;
  }

  /**
   * Render data.
   */
  public function report() {
    \Drupal::service('page_cache_kill_switch')->trigger();
    $form = $this->buildForm();
    $result = $this->load();
    $result = json_decode(json_encode($result), TRUE);
    foreach ($result as $row) {
      if ($row['avatar__target_id'] !== NULL) {
        $avatar = File::load($row['avatar__target_id']);
        $avatarUri = $avatar->getFileUri();
        $avatarVariables = [
          '#theme' => 'image',
          '#uri' => $avatarUri,
          '#alt' => 'Avatar',
          '#title' => 'Avatar',
        ];
        $avatarUrl = file_url_transform_relative(Url::fromUri(file_create_url($avatarUri))
          ->toString());
      }
      else {
        $avatarVariables = [];
        $avatarUrl = '';
      }
      if ($row['image__target_id'] !== NULL) {
        $image = File::load($row['image__target_id']);
        $imageUri = $image->getFileUri();
        $imageVariables = [
          '#theme' => 'image',
          '#uri' => $imageUri,
          '#alt' => 'Avatar',
          '#title' => 'Avatar',
        ];
        $imageUrl = file_url_transform_relative(Url::fromUri(file_create_url($imageUri))
          ->toString());
      }
      else {
        $imageVariables = [];
        $imageUrl = '';
      }
      $data[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'telephone' => $row['telephone'],
        'message' => $row['message'],
        'avatar__target_id' => [
          'data' => $avatarVariables,
          'url' => $avatarUrl,
        ],
        'image__target_id' => [
          'data' => $imageVariables,
          'url' => $imageUrl,
        ],
        'timestamp' => $row['timestamp'],
      ];
    }

    return [
      'form' => $form,
      'posts' => [
        '#theme' => 'guestbook',
        '#rows' => $data,
      ],
    ];
  }

}
