<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyInputValidation\Exception\ViolationException;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\ConstraintViolationList;
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
        $violationList  = new ConstraintViolationList();
        $validatedInput = new $validatedInputClass($input, $violationList);

        // validate
        $constraint = $this->constraintFactory->createConstraint($validatedInput->getValidationRules());
        $violations = $this->validator->validate($input, $constraint);

        // throw exception if requested
        if ($throw && count($violations) > 0) {
            throw new ViolationException($violations);
        }

        // otherwise add violations to input
        $violationList->addAll($violations);

        return $validatedInput;
    }
}
