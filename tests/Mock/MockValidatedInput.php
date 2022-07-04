<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Mock;

use DigitalRevolution\SymfonyConsoleValidation\AbstractValidatedInput;
use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;

class MockValidatedInput extends AbstractValidatedInput
{
    public static ?ValidationRules $validationRules = null;

    public function getValidationRules(): ValidationRules
    {
        return self::$validationRules ?? new ValidationRules();
    }
}
