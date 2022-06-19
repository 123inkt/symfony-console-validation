<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;

/**
 * @phpstan-type ConstraintList Constraint|array<string, string|Constraint|array<string|Constraint>>
 * @phpstan-type DefinitionCollection array{arguments?: DefinitionCollection, options?: DefinitionCollection }
 */
class ValidationRules
{
    /** @phpstan-var DefinitionCollection $definitions */
    private array $definitions;
    private bool  $allowExtraFields;

    /**
     * @phpstan-param DefinitionCollection $definitions
     * @param bool                         $allowExtraFields Allow the input to have extra fields, not present in the definition list
     */
    public function __construct(array $definitions, bool $allowExtraFields = false)
    {
        // expect no other keys than `arguments` or `options`
        if (count(array_diff(array_keys($definitions), ['arguments', 'options'])) > 0) {
            throw new InvalidArgumentException('Expecting at most `arguments` or `options` property to be set');
        }

        $this->definitions      = $definitions;
        $this->allowExtraFields = $allowExtraFields;
    }

    /**
     * @phpstan-return DefinitionCollection $definitions
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function isAllowExtraFields(): bool
    {
        return $this->allowExtraFields;
    }
}
