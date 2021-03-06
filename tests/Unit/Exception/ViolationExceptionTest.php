<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Exception;

use DigitalRevolution\SymfonyConsoleValidation\Exception\ViolationException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyConsoleValidation\Exception\ViolationException
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
        $violationA = new ConstraintViolation('messageA', null, [], null, 'pathA', 'invalidA');
        $violationB = new ConstraintViolation('messageB', null, [], null, 'pathB', 'invalidB');
        $list       = new ConstraintViolationList([$violationA, $violationB]);

        $exception = new ViolationException($list);
        static::assertSame("pathA: `invalidA`. messageA\npathB: `invalidB`. messageB", $exception->getMessage());
        static::assertSame($list, $exception->getViolations());
    }
}
