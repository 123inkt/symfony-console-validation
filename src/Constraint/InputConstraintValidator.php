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
            $this->context->getValidator()
                ->inContext($this->context)
                ->atPath('[arguments]')
                ->validate($input->getArguments(), $constraint->arguments);
        } elseif ($constraint->allowExtraFields === false && count($input->getArguments()) > 0) {
            $this->context->buildViolation($constraint->queryMessage)
                ->atPath('[arguments]')
                ->setCode($constraint::MISSING_ARGUMENTS_CONSTRAINT)
                ->addViolation();
        }
    }

    private function validateOptions(InputConstraint $constraint, InputInterface $input): void
    {
        if ($constraint->options !== null) {
            $this->context->getValidator()
                ->inContext($this->context)
                ->atPath('[options]')
                ->validate($input->getOptions(), $constraint->options);
        } elseif ($constraint->allowExtraFields === false && count($input->getOptions()) > 0) {
            $this->context->buildViolation($constraint->requestMessage)
                ->atPath('[options]')
                ->setCode($constraint::MISSING_OPTIONS_CONSTRAINT)
                ->addViolation();
        }
    }
}
