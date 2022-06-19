<?php
declare(strict_types=1);

namespace Exception;

use DigitalRevolution\SymfonyInputValidation\Exception\ViolationException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyInputValidation\Exception\ViolationException
 * @covers ::__construct
 */
class ViolationExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getViolations
     */
    public function testConstruct(): void
    {
        $violationA = new ConstraintViolation('messageA', null, [], null, 'pathA', null);
        $violationB = new ConstraintViolation('messageB', null, [], null, 'pathB', null);
        $list       = new ConstraintViolationList([$violationA, $violationB]);

        $exception = new ViolationException($list);
        static::assertSame("pathA: messageA\npathB: messageB", $exception->getMessage());
        static::assertSame($list, $exception->getViolations());
    }
}
