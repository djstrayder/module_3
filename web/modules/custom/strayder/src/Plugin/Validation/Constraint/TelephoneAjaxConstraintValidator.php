<?php

namespace Drupal\strayder\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation ajax for telephone.
 *
 * @package Drupal\strayder\Plugin\Validation\Constraint
 */
class TelephoneAjaxConstraintValidator extends ConstraintValidator {

  /**
   * @param mixed $value
   * @param \Symfony\Component\Validator\Constraint $constraint
   */
  public function validate($value, Constraint $constraint) {
    if (!filter_var($value->value, FILTER_VALIDATE_INT) || !preg_match('/^\+?3?8?(0\d{9})$/', $value->value)) {
      $this->context->addViolation($constraint->message);
    }

  }

}
