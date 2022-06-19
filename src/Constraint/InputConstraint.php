<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Constraint;

use Symfony\Component\Validator\Constraint;

class InputConstraint extends Constraint
{
    public const WRONG_VALUE_TYPE             = '67ff49d5-9a61-47ad-80f1-960fd2beab6f';
    public const MISSING_ARGUMENTS_CONSTRAINT = 'ab383f80-ee51-4fdd-bdeb-36d868fe1e13';
    public const MISSING_OPTIONS_CONSTRAINT   = 'e6808855-9b1f-498a-8f5a-0df219c3cb97';

    /** @var array<string, string> */
    protected static $errorNames = [
        self::WRONG_VALUE_TYPE             => 'WRONG_VALUE_TYPE',
        self::MISSING_ARGUMENTS_CONSTRAINT => 'MISSING_ARGUMENTS_CONSTRAINT',
        self::MISSING_OPTIONS_CONSTRAINT   => 'MISSING_OPTIONS_CONSTRAINT',
    ];

    public string $wrongTypeMessage = 'Expect value to be of type Symfony\Component\Console\Input\InputInterface';
    public string $queryMessage     = 'Input::arguments is not empty, but there is no constraint configured.';
    public string $requestMessage   = 'Input::options is not empty, but there is no constraint configured.';

    /** @var Constraint|Constraint[]|null */
    public Constraint|array|null $arguments;

    /** @var Constraint|Constraint[]|null */
    public Constraint|array|null $options;

    public bool $allowExtraFields;

    /**
     * @param array{
     *     arguments?: Constraint|Constraint[],
     *     options?: Constraint|Constraint[],
     *     allowExtraFields?: bool
     *     }|null $options
     */
    public function __construct($options = null)
    {
        // make sure defaults are set
        $options                     = $options ?? [];
        $options['arguments']        = $options['arguments'] ?? null;
        $options['options']          = $options['options'] ?? null;
        $options['allowExtraFields'] = $options['allowExtraFields'] ?? false;

        parent::__construct($options);
    }

    public function getRequiredOptions(): array
    {
        return ['arguments', 'options', 'allowExtraFields'];
    }
}
