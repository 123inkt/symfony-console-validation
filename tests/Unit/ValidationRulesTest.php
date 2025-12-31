<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit;

use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ValidationRules::class)]
class ValidationRulesTest extends TestCase
{
    public function testConstructor(): void
    {
        $config = [
            'arguments' => ['email' => 'required|string'],
            'options'   => ['persist' => 'string']
        ];

        $rules = new ValidationRules($config);
        static::assertSame($config, $rules->getDefinitions());
    }

    public function testConstructorFailure(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expecting at most `arguments` or `options` ');
        new ValidationRules(['foobar']);
    }

    public function testAddArgumentConstraint(): void
    {
        $rules = new ValidationRules();
        $rules->addArgumentConstraint('email', 'required|string');
        static::assertSame(['arguments' => ['email' => 'required|string']], $rules->getDefinitions());
    }

    public function testAddOptionConstraint(): void
    {
        $rules = new ValidationRules();
        $rules->addOptionConstraint('email', 'required|string');
        static::assertSame(['options' => ['email' => 'required|string']], $rules->getDefinitions());
    }
}
