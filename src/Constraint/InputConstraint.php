<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Constraint;

use Symfony\Component\Validator\Constraint;

class InputConstraint extends Constraint
{
    /** @var string */
    public const WRONG_VALUE_TYPE = '67ff49d5-9a61-47ad-80f1-960fd2beab6f';

    protected const ERROR_NAMES = [self::WRONG_VALUE_TYPE => 'WRONG_VALUE_TYPE',];

    public string $wrongTypeMessage = 'Expect value to be of type Symfony\Component\Console\Input\InputInterface';

    /**
     * @param Constraint|Constraint[]|null $arguments
     * @param Constraint|Constraint[]|null $options
     */
    public function __construct(public Constraint|array|null $arguments = null, public Constraint|array|null $options = null)
    {
        parent::__construct();
    }
}
