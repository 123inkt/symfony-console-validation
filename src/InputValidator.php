<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputValidator
{
    private InputConstraintFactory $constraintFactory;

    public function __construct(private ValidatorInterface $validator, ?InputConstraintFactory $constraintFactory = null)
    {
        $this->constraintFactory = $constraintFactory ?? new InputConstraintFactory(new ConstraintFactory());
    }

    /**
     * @template T of AbstractValidatedInput
     * @param class-string<T> $inputValidator
     * @return T
     * @throws InvalidRuleException
     */
    public function validate(InputInterface $input, string $inputValidator): AbstractValidatedInput
    {
        $constraint = $this->constraintFactory->createConstraint($inputValidator::getValidationRules());
        $violations = $this->validator->validate($input, $constraint);

        return new $inputValidator($input, $violations);
    }

    public function getName(): string
    {
        return 'validator';
    }
}
