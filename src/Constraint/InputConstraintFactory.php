<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use Symfony\Component\Validator\Constraint;

class InputConstraintFactory
{
    private ConstraintFactory $factory;

    public function __construct(ConstraintFactory $factory = null)
    {
        $this->factory = $factory ?? new ConstraintFactory();
    }

    /**
     * @throws InvalidRuleException
     */
    public function createConstraint(ValidationRules $validationRules): InputConstraint
    {
        $options = [];
        foreach ($validationRules->getDefinitions() as $key => $definitions) {
            $options[$key] = $this->factory->fromRuleDefinitions($definitions, true);
        }

        return new InputConstraint($options);
    }
}
