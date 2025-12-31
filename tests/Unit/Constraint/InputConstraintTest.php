<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraint;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

#[CoversClass(InputConstraint::class)]
class InputConstraintTest extends TestCase
{
    public function testConstructDefaultOptions(): void
    {
        $constraint = new InputConstraint();
        static::assertNull($constraint->arguments);
        static::assertNull($constraint->options);
    }

    public function testConstructConstraintOptions(): void
    {
        $constraintA = new NotBlank();
        $constraintB = new NotNull();
        $constraint  = new InputConstraint($constraintA, $constraintB);
        static::assertSame($constraintA, $constraint->arguments);
        static::assertSame($constraintB, $constraint->options);
    }
}
