<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Unit\Constraint;

use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraint;
use DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraintValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @coversDefaultClass \DigitalRevolution\SymfonyConsoleValidation\Constraint\InputConstraintValidator
 */
class InputConstraintValidatorTest extends TestCase
{
    private ExecutionContext         $context;
    private InputConstraintValidator $validator;

    protected function setUp(): void
    {
        $translatorMock = $this->createMock(TranslatorInterface::class);
        $translatorMock->method('trans')->willReturn('');

        $this->validator = new InputConstraintValidator();
        $this->context   = new ExecutionContext(Validation::createValidator(), 'root', $translatorMock);
        $this->validator->initialize($this->context);
    }

    /**
     * @covers ::validate
     */
    public function testValidateUnexpectedTypeException(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->validator->validate(null, new Assert\NotBlank());
    }

    /**
     * @param array<string, string> $data
     * @dataProvider \DigitalRevolution\SymfonyConsoleValidation\Tests\DataProvider\Constraint\InputConstraintValidatorDataProvider::argumentDataProvider
     * @covers ::validate
     */
    public function testValidateArguments(array $data, bool $success): void
    {
        $definition = new InputDefinition([new InputArgument('email', InputArgument::REQUIRED)]);
        $input      = new ArrayInput($data, $definition);
        $constraint = new InputConstraint(new Assert\Collection(['email' => new Assert\Required(new Assert\Email())]));
        $this->context->setConstraint($constraint);
        $this->validator->validate($input, $constraint);
        static::assertCount($success ? 0 : 1, $this->context->getViolations());
    }

    /**
     * @param array<string, string> $data
     * @dataProvider \DigitalRevolution\SymfonyConsoleValidation\Tests\DataProvider\Constraint\InputConstraintValidatorDataProvider::optionDataProvider
     * @covers ::validate
     */
    public function testValidateOptions(array $data, bool $success): void
    {
        $definition = new InputDefinition(
            [
                new InputOption('email', '', InputOption::VALUE_REQUIRED),
                new InputOption('absent', '', InputOption::VALUE_REQUIRED)
            ]
        );
        $input      = new ArrayInput($data, $definition);
        $constraint = new InputConstraint(options: new Assert\Collection(['email' => new Assert\Optional(new Assert\Email())]));
        $this->context->setConstraint($constraint);
        $this->validator->validate($input, $constraint);
        static::assertCount($success ? 0 : 1, $this->context->getViolations());
    }

    /**
     * @covers ::validate
     */
    public function testValidateNullInput(): void
    {
        $input      = null;
        $constraint = new InputConstraint();
        $this->context->setConstraint($constraint);
        $this->validator->validate($input, $constraint);
        static::assertCount(0, $this->context->getViolations());
    }

    /**
     * @covers ::validate
     */
    public function testValidateWrongTypeViolation(): void
    {
        $input      = 5;
        $constraint = new InputConstraint();
        $this->context->setConstraint($constraint);
        $this->validator->validate($input, $constraint);
        $violations = $this->context->getViolations();
        static::assertCount(1, $violations);
        static::assertSame($constraint->wrongTypeMessage, $violations->get(0)->getMessageTemplate());
    }
}
