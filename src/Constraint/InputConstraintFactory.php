<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;

class InputConstraintFactory
{
    public function __construct(private ConstraintFactory $factory = new ConstraintFactory())
    {
    }

    /**
     * @throws InvalidRuleException
     */
    public function createConstraint(ValidationRules $validationRules): InputConstraint
    {
        $definitions = $validationRules->getDefinitions();
        $arguments   = $options = null;

        if (isset($definitions['arguments'])) {
            $arguments = $this->factory->fromRuleDefinitions($definitions['arguments'], true);
        }
        if (isset($definitions['options'])) {
            $options = $this->factory->fromRuleDefinitions($definitions['options'], true);
        }

        return new InputConstraint($arguments, $options);
    }
}
