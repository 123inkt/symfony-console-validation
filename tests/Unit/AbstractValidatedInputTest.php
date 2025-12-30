<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit;

use DigitalRevolution\SymfonyConsoleValidation\AbstractValidatedInput;
use DigitalRevolution\SymfonyConsoleValidation\Tests\Mock\MockValidatedInput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

#[CoversClass(AbstractValidatedInput::class)]
class AbstractValidatedInputTest extends TestCase
{
    public function testIsValid(): void
    {
        $list = new ConstraintViolationList();

        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);
        static::assertTrue($validatedInput->isValid());

        $list->add(new ConstraintViolation('message', null, [], null, 'path', null));
        static::assertFalse($validatedInput->isValid());
    }

    public function testGetViolations(): void
    {
        $list           = new ConstraintViolationList([new ConstraintViolation('message', null, [], null, 'path', null)]);
        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);

        static::assertSame($list, $validatedInput->getViolations());
    }

    public function testGetViolationMessages(): void
    {
        $list           = new ConstraintViolationList([new ConstraintViolation('message', null, [], null, 'path', null)]);
        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);

        static::assertSame(['message'], $validatedInput->getViolationMessages());
    }
}
