<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Tests\Unit;

use DigitalRevolution\SymfonyInputValidation\Tests\Mock\MockValidatedInput;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyInputValidation\AbstractValidatedInput
 * @covers ::__construct
 */
class AbstractValidatedInputTest extends TestCase
{
    /**
     * @covers ::isValid
     */
    public function testIsValid(): void
    {
        $list = new ConstraintViolationList();

        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);
        static::assertTrue($validatedInput->isValid());

        $list->add(new ConstraintViolation('message', null, [], null, 'path', null));
        static::assertFalse($validatedInput->isValid());
    }

    /**
     * @covers ::getViolations
     */
    public function testGetViolations(): void
    {
        $list           = new ConstraintViolationList([new ConstraintViolation('message', null, [], null, 'path', null)]);
        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);

        static::assertSame($list, $validatedInput->getViolations());
    }

    /**
     * @covers ::getViolationMessages
     */
    public function testGetViolationMessages(): void
    {
        $list           = new ConstraintViolationList([new ConstraintViolation('message', null, [], null, 'path', null)]);
        $validatedInput = new MockValidatedInput(new ArrayInput([]), $list);

        static::assertSame(['message'], $validatedInput->getViolationMessages());
    }
}
