<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Exception;

use DigitalRevolution\SymfonyConsoleValidation\Exception\ViolationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

#[CoversClass(ViolationException::class)]
class ViolationExceptionTest extends TestCase
{
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
