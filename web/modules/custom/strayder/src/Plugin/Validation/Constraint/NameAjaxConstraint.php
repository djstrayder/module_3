<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Constraint (
 *   id = "NameValidateAjax",
 *   label = @Translation("Name Validation"),
 * )
 */
class NameAjaxConstraint extends Constraint {

  /**
   *
   * @var string
   */
  public $message = 'Your name is incorrect';

}
