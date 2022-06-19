<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyInputValidation\Exception\ViolationException;
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
     * @param class-string<T> $validatedInputClass
     * @return T
     * @throws ViolationException|InvalidRuleException
     */
    public function validate(InputInterface $input, string $validatedInputClass, bool $throw = true): AbstractValidatedInput
    {
        $constraint = $this->constraintFactory->createConstraint($validatedInputClass::getValidationRules());
        $violations = $this->validator->validate($input, $constraint);

        /** @var AbstractValidatedInput $validatedInput */
        $validatedInput = new $validatedInputClass($input, $violations);
        if ($throw && $validatedInput->isValid() === false) {
            throw new ViolationException($validatedInput->getViolationMessages());
        }

        return $validatedInput;
    }

    public function getName(): string
    {
        return 'validator';
    }
}
