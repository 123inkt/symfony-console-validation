<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\DataProvider\Constraint;

class InputConstraintValidatorDataProvider
{
    /**
     * @return array<string, array<array, bool>>
     */
    public static function argumentDataProvider(): array
    {
        return [
            'success' => [['email' => 'example@example.com'], true],
            'failure' => [['email' => 'unit test'], false]
        ];
    }

    /**
     * @return array<string, array<array, bool>>
     */
    public static function optionDataProvider(): array
    {
        return [
            'success' => [['--email' => 'example@example.com'], true],
            'failure' => [['--email' => 'unit test'], false]
        ];
    }
}
