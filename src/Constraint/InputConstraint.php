<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Constraint;

use Symfony\Component\Validator\Constraint;

class InputConstraint extends Constraint
{
    public const WRONG_VALUE_TYPE = '67ff49d5-9a61-47ad-80f1-960fd2beab6f';

    protected const ERROR_NAMES = [self::WRONG_VALUE_TYPE => 'WRONG_VALUE_TYPE',];

    public string $wrongTypeMessage = 'Expect value to be of type Symfony\Component\Console\Input\InputInterface';

    /** @var Constraint|Constraint[]|null */
    public Constraint|array|null $arguments;

    /** @var Constraint|Constraint[]|null */
    public Constraint|array|null $options;

    /**
     * @param array{
     *     arguments?: Constraint|Constraint[],
     *     options?: Constraint|Constraint[]
     * }|null $options
     */
    public function __construct(?array $options = null)
    {
        // make sure defaults are set
        $options              = $options ?? [];
        $options['arguments'] = $options['arguments'] ?? null;
        $options['options']   = $options['options'] ?? null;

        parent::__construct($options);
    }

    public function getRequiredOptions(): array
    {
        return ['arguments', 'options'];
    }
}
