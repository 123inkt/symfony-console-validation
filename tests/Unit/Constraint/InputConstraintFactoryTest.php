<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraint;
use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

#[CoversClass(InputConstraintFactory::class)]
class InputConstraintFactoryTest extends TestCase
{
    private InputConstraintFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $constraintFactory = $this->createMock(ConstraintFactory::class);
        $constraintFactory->method('fromRuleDefinitions')->willReturnArgument(0);
        $this->factory = new InputConstraintFactory($constraintFactory);
    }

    /**
     * @throws InvalidRuleException
     */
    public function testCreateInputConstraintWithoutRules(): void
    {
        // without any rules
        $result = $this->factory->createConstraint(new ValidationRules([]));
        static::assertEquals(new InputConstraint(), $result);
    }

    /**
     * @throws InvalidRuleException
     */
    public function testCreateInputConstraintWithRules(): void
    {
        $constraintA = new Assert\NotNull();
        $constraintB = new Assert\NotBlank();
        $result      = $this->factory->createConstraint(new ValidationRules(['arguments' => $constraintA, 'options' => $constraintB]));
        static::assertEquals(new InputConstraint($constraintA, $constraintB), $result);
    }
}
