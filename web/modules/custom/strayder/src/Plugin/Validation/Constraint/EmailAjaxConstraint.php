<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Constraint (
 *   id = "EmailValidateAjax",
 *   label = @Translation("Email Validation"),
 * )
 */
class EmailAjaxConstraint extends Constraint {

  /**
   *
   * @var string
   */
  public $message = 'Your email is incorrect';

}
