<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Tests\Unit;

use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraint;
use DigitalRevolution\SymfonyInputValidation\Constraint\InputConstraintFactory;
use DigitalRevolution\SymfonyInputValidation\Exception\ViolationException;
use DigitalRevolution\SymfonyInputValidation\InputValidator;
use DigitalRevolution\SymfonyInputValidation\Tests\Mock\MockValidatedInput;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyInputValidation\InputValidator
 * @covers ::__construct
 */
class InputValidatorTest extends TestCase
{
    /** @var InputConstraintFactory&MockObject */
    private InputConstraintFactory $constraintFactory;
    /** @var ValidatorInterface&MockObject */
    private ValidatorInterface $validator;
    private InputValidator     $inputValidator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->constraintFactory = $this->createMock(InputConstraintFactory::class);
        $this->validator         = $this->createMock(ValidatorInterface::class);
        $this->inputValidator    = new InputValidator($this->validator, $this->constraintFactory);
    }

    /**
     * @covers ::validate
     * @throws InvalidRuleException
     */
    public function testValidateFailureWithThrows(): void
    {
        $input      = new ArrayInput([]);
        $constraint = new InputConstraint();

        $violation     = new ConstraintViolation('message', null, [], null, 'path', null);
        $violationList = new ConstraintViolationList([$violation]);

        $this->constraintFactory->expects(self::once())->method('createConstraint')->willReturn($constraint);
        $this->validator->expects(self::once())->method('validate')->with($input, $constraint)->willReturn($violationList);

        $this->expectException(ViolationException::class);
        $this->inputValidator->validate($input, MockValidatedInput::class);
    }

    /**
     * @covers ::validate
     * @throws InvalidRuleException|ViolationException
     */
    public function testValidateFailureWithoutThrows(): void
    {
        $input      = new ArrayInput([]);
        $constraint = new InputConstraint();

        $violation     = new ConstraintViolation('message', null, [], null, 'path', null);
        $violationList = new ConstraintViolationList([$violation]);

        $this->constraintFactory->expects(self::once())->method('createConstraint')->willReturn($constraint);
        $this->validator->expects(self::once())->method('validate')->with($input, $constraint)->willReturn($violationList);

        $validatedInput = $this->inputValidator->validate($input, MockValidatedInput::class, false);
        static::assertFalse($validatedInput->isValid());
        static::assertSame($violationList, $validatedInput->getViolations());
    }


    /**
     * @covers ::validate
     * @throws InvalidRuleException|ViolationException
     */
    public function testValidateSuccess(): void
    {
        $input         = new ArrayInput([]);
        $constraint    = new InputConstraint();
        $violationList = new ConstraintViolationList([]);

        $this->constraintFactory->expects(self::once())->method('createConstraint')->willReturn($constraint);
        $this->validator->expects(self::once())->method('validate')->with($input, $constraint)->willReturn($violationList);

        $validatedInput = $this->inputValidator->validate($input, MockValidatedInput::class);
        static::assertTrue($validatedInput->isValid());
        static::assertSame($violationList, $validatedInput->getViolations());
    }
}
