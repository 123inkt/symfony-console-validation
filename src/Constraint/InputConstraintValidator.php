<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Constraint;

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
            $context->buildViolation($constraint->wrongTypeMessage)
                ->setCode($constraint::WRONG_VALUE_TYPE)
                ->addViolation();

            return;
        }

        $this->validateArguments($constraint, $value);
        $this->validateOptions($constraint, $value);
    }

    private function validateArguments(InputConstraint $constraint, InputInterface $input): void
    {
        if ($constraint->arguments !== null) {
            $this->context->getValidator()->inContext($this->context)->validate($input->getArguments(), $constraint->arguments);
        }
    }

    private function validateOptions(InputConstraint $constraint, InputInterface $input): void
    {
        $options = array_filter($input->getOptions(), static fn($option) => $option !== null);

        if ($constraint->options !== null) {
            $this->context->getValidator()->inContext($this->context)->validate($options, $constraint->options);
        }
    }
}
