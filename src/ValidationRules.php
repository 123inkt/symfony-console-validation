<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;

/**
 * @phpstan-type ConstraintList string|Constraint|array<string, string|Constraint|array<string|Constraint>>
 * @phpstan-type DefinitionCollection array{arguments?: ConstraintList, options?: ConstraintList }
 */
class ValidationRules
{
    /** @phpstan-var DefinitionCollection $definitions */
    private array $definitions;

    /**
     * @phpstan-param DefinitionCollection $definitions
     */
    public function __construct(array $definitions = [])
    {
        // expect no other keys than `arguments` or `options`
        if (count(array_diff(array_keys($definitions), ['arguments', 'options'])) > 0) {
            throw new InvalidArgumentException('Expecting at most `arguments` or `options` property to be set');
        }

        $this->definitions = $definitions;
    }

    /**
     * @phpstan-param ConstraintList $constraintList
     */
    public function addArgumentConstraint(string $argumentName, string|Constraint|array $constraintList): static
    {
        $this->definitions['arguments'][$argumentName] = $constraintList;

        return $this;
    }

    /**
     * @phpstan-param ConstraintList $constraintList
     */
    public function addOptionConstraint(string $optionName, string|Constraint|array $constraintList): static
    {
        $this->definitions['options'][$optionName] = $constraintList;

        return $this;
    }

    /**
     * @phpstan-return DefinitionCollection $definitions
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }
}
