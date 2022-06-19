<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Tests\Mock;

use DigitalRevolution\SymfonyInputValidation\AbstractValidatedInput;
use DigitalRevolution\SymfonyInputValidation\ValidationRules;

class MockValidatedInput extends AbstractValidatedInput
{
    public static function getValidationRules(): ValidationRules
    {
        return new ValidationRules();
    }
}
