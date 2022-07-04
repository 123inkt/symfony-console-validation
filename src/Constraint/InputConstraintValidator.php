<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Constraint;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class InputConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($constraint instanceof InputConstraint === false) {
            throw new UnexpectedTypeException($constraint, InputConstraint::class);
        }

        if ($value === null) {
            return;
        }

        $context = $this->context;
        if ($value instanceof InputInterface === false) {
            $context->buildViolation($constraint->wrongTypeMessage)->setCode($constraint::WRONG_VALUE_TYPE)->addViolation();

            return;
        }

        // validate arguments
        if ($constraint->arguments !== null) {
            $this->context->getValidator()->inContext($this->context)->validate($value->getArguments(), $constraint->arguments);
        }

        // validate options
        if ($constraint->options !== null) {
            $options = array_filter($value->getOptions(), static fn($option) => $option !== null);
            $this->context->getValidator()->inContext($this->context)->validate($options, $constraint->options);
        }
    }
}
