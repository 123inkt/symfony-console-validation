<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Mock;

use DigitalRevolution\SymfonyConsoleValidation\AbstractValidatedInput;
use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;

class MockValidatedInput extends AbstractValidatedInput
{
    public function getValidationRules(): ValidationRules
    {
        return new ValidationRules();
    }
}
