<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraint;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraint
 */
class InputConstraintTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructDefaultOptions(): void
    {
        $constraint = new InputConstraint();
        static::assertNull($constraint->arguments);
        static::assertNull($constraint->options);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructConstraintOptions(): void
    {
        $constraintA = new NotBlank();
        $constraintB = new NotNull();
        $constraint  = new InputConstraint($constraintA, $constraintB);
        static::assertSame($constraintA, $constraint->arguments);
        static::assertSame($constraintB, $constraint->options);
    }
}
