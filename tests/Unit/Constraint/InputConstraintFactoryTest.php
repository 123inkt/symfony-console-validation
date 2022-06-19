<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Tests\Unit\Constraint;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraint;
use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyInputValidation\ValidationRules;
use DigitalRevolution\SymfonyValidationShorthand\ConstraintFactory;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory
 * @covers ::__construct
 */
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
     * @covers ::createConstraint
     * @throws InvalidRuleException
     */
    public function testCreateInputConstraintWithoutRules(): void
    {
        // without any rules
        $result = $this->factory->createConstraint(new ValidationRules([]));
        static::assertEquals(new InputConstraint(), $result);
    }

    /**
     * @covers ::createConstraint
     * @throws InvalidRuleException
     */
    public function testCreateInputConstraintWithRules(): void
    {
        $constraintA = new Assert\NotNull();
        $constraintB = new Assert\NotBlank();
        $result      = $this->factory->createConstraint(new ValidationRules(['arguments' => $constraintA, 'options' => $constraintB]));
        static::assertEquals(new InputConstraint(['arguments' => $constraintA, 'options' => $constraintB]), $result);
    }
}
