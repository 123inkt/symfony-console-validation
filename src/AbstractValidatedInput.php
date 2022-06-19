<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidatedInput
{
    /** @var ConstraintViolationListInterface<ConstraintViolationInterface> */
    private ConstraintViolationListInterface $violationList;

    /**
     * @throws InvalidRuleException
     */
    public function __construct(private InputInterface $input, ValidatorInterface $validator, ?InputConstraintFactory $constraintFactory = null)
    {
        $constraintFactory   ??= new InputConstraintFactory(new ConstraintFactory());
        $this->violationList = $validator->validate($this->input, $constraintFactory->createConstraint($this->getValidationRules()));
    }

    public function isValid(): bool
    {
        return count($this->violationList) === 0;
    }

    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    /**
     * Get all the constraints for the current query params
     */
    abstract protected function getValidationRules(): ValidationRules;
}
