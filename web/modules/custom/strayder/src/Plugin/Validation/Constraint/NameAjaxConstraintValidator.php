<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation ajax for name.
 *
 * @package Drupal\strayder\Plugin\Validation\Constraint
 */
class NameAjaxConstraintValidator extends ConstraintValidator {

  /**
   * @param mixed $value
   * @param \Symfony\Component\Validator\Constraint $constraint
   */
  public function validate($value, Constraint $constraint) {
    if (strlen($value->value) < 2) {
      $this->context->addViolation($constraint->message);
    }

  }

}
