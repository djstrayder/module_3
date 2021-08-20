<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Constraint (
 *   id = "TelephoneValidateAjax",
 *   label = @Translation("Telephone Validation"),
 * )
 */
class TelephoneAjaxConstraint extends Constraint {

  /**
   *
   * @var string
   */
  public $message = 'Your telephone is incorrect';

}
