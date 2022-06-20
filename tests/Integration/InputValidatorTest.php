<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Tests\Integration;

use DigitalRevolution\SymfonyConsoleValidation\Exception\ViolationException;
use DigitalRevolution\SymfonyConsoleValidation\InputValidator;
use DigitalRevolution\SymfonyConsoleValidation\Tests\Mock\MockValidatedInput;
use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Validator\Validation;

/**
 * @coversNothing
 */
class InputValidatorTest extends TestCase
{
    private InputValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new InputValidator(Validation::createValidator());
    }

    protected function tearDown(): void
    {
        parent::setUp();
        MockValidatedInput::$validationRules = null;
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testArgumentValidationSuccess(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['arguments' => ['email' => 'required|string|email']]);

        $definition     = new InputDefinition([new InputArgument('email', InputArgument::REQUIRED)]);
        $input          = new ArrayInput(['email' => 'sherlock@example.com'], $definition);
        $validatedInput = $this->validator->validate($input, MockValidatedInput::class);
        static::assertTrue($validatedInput->isValid());
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testArgumentValidationFailureThrowsException(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['arguments' => ['email' => 'required|string|email']]);

        $definition = new InputDefinition([new InputArgument('email', InputArgument::REQUIRED)]);
        $input      = new ArrayInput(['email' => 'foobar'], $definition);

        $this->expectException(ViolationException::class);
        $this->expectExceptionMessage('email: `foobar`. This value is not a valid email address.');
        $this->validator->validate($input, MockValidatedInput::class);
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testArgumentValidationFailureReturnsValidatedInput(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['arguments' => ['email' => 'required|string|email']]);

        $definition = new InputDefinition([new InputArgument('email', InputArgument::REQUIRED)]);
        $input      = new ArrayInput(['email' => 'foobar'], $definition);

        $validatedInput = $this->validator->validate($input, MockValidatedInput::class, false);
        static::assertFalse($validatedInput->isValid());
        static::assertSame(['This value is not a valid email address.'], $validatedInput->getViolationMessages());
    }


    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testOptionValidationSuccess(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['options' => ['email' => 'string|email']]);

        $definition     = new InputDefinition([new InputOption('email', '', InputOption::VALUE_REQUIRED)]);
        $input          = new ArrayInput(['--email' => 'sherlock@example.com'], $definition);
        $validatedInput = $this->validator->validate($input, MockValidatedInput::class);
        static::assertTrue($validatedInput->isValid());
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testOptionValidationSuccessWithFlag(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['options' => ['debug' => 'bool']]);

        $definition     = new InputDefinition([new InputOption('debug', '', InputOption::VALUE_NONE)]);
        $input          = new ArrayInput(['--debug' => true], $definition);
        $validatedInput = $this->validator->validate($input, MockValidatedInput::class);
        static::assertTrue($validatedInput->isValid());
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testOptionValidationFailureThrowsException(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['options' => ['email' => 'string|email']]);

        $definition     = new InputDefinition([new InputOption('email', '', InputOption::VALUE_REQUIRED)]);
        $input          = new ArrayInput(['--email' => 'foobar'], $definition);

        $this->expectException(ViolationException::class);
        $this->expectExceptionMessage('email: `foobar`. This value is not a valid email address.');
        $this->validator->validate($input, MockValidatedInput::class);
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    public function testOptionValidationFailureReturnsValidatedInput(): void
    {
        MockValidatedInput::$validationRules = new ValidationRules(['options' => ['email' => 'string|email']]);

        $definition     = new InputDefinition([new InputOption('email', '', InputOption::VALUE_REQUIRED)]);
        $input          = new ArrayInput(['--email' => 'foobar'], $definition);

        $validatedInput = $this->validator->validate($input, MockValidatedInput::class, false);
        static::assertFalse($validatedInput->isValid());
        static::assertSame(['This value is not a valid email address.'], $validatedInput->getViolationMessages());
    }
}
