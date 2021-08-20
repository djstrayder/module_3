<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation ajax for email.
 *
 * @package Drupal\strayder\Plugin\Validation\Constraint
 */
class EmailAjaxConstraintValidator extends ConstraintValidator {

  /**
   * @param mixed $value
   * @param \Symfony\Component\Validator\Constraint $constraint
   */
  public function validate($value, Constraint $constraint) {
    if ((!filter_var($value->value, FILTER_VALIDATE_EMAIL))) {
      $this->context->addViolation($constraint->message);
    }

  }

}
