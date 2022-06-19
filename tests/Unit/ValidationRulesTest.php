<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Tests\Unit;

use DigitalRevolution\SymfonyInputValidation\ValidationRules;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyInputValidation\ValidationRules
 */
class ValidationRulesTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getDefinitions
     */
    public function testConstructor(): void
    {
        $config = [
            'arguments' => ['email' => 'required|string'],
            'options'   => ['persist' => 'string']
        ];

        $rules = new ValidationRules($config);
        static::assertSame($config, $rules->getDefinitions());
    }

    /**
     * @covers ::addArgumentConstraint
     * @covers ::getDefinitions
     */
    public function testAddArgumentConstraint(): void
    {
        $rules = new ValidationRules();
        $rules->addArgumentConstraint('email', 'required|string');
        static::assertSame(['arguments' => ['email' => 'required|string']], $rules->getDefinitions());
    }

    /**
     * @covers ::addOptionConstraint
     * @covers ::getDefinitions
     */
    public function testAddOptionConstraint(): void
    {
        $rules = new ValidationRules();
        $rules->addOptionConstraint('email', 'required|string');
        static::assertSame(['arguments' => ['email' => 'required|string']], $rules->getDefinitions());
    }
}
