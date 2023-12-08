[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF)](https://php.net/)
[![Minimum Symfony Version](https://img.shields.io/badge/symfony-%3E%3D%206.2-brightgreen)](https://symfony.com/doc/current/validation.html)
![Run checks](https://github.com/123inkt/symfony-console-validation/actions/workflows/test.yml/badge.svg)

# Symfony Console Validation
An input validation component for Symfony Console. Ease the validation of input arguments and options.

## Installation
Include the library as dependency in your own project via:
```
composer require digitalrevolution/symfony-console-validation
```

## Usage

1) Create your own `ExampleInput` class which extends the `AbstractValidatedInput` class.
2) Configure your own `ValidationRules`. See the [Validation shorthand library](https://github.com/123inkt/symfony-validation-shorthand) for
   more information about the rules.
3) Ensure the `InputValidator` class is registered as [service in your Symfony project](https://symfony.com/doc/current/service_container.html).

```php
use DigitalRevolution\SymfonyConsoleValidation\AbstractValidatedInput;
use DigitalRevolution\SymfonyConsoleValidation\ValidationRules;

class ExampleInput extends AbstractValidatedInput
{
    public static function getValidationRules(): ValidationRules
    {
        return new ValidationRules([
            'arguments' => [
                'email'   => 'required|string|email'                
            ],
            'options' => [
                'projectId' => 'int:min:1'
]           
        ]);
    }

    public function getEmail(): string
    {
        return $this->input->getArgument('email');
    }
    
    public function getProjectId(): ?int
    {
        $value = $this->input->getOption('projectId');
    
        return $value === null ? null : (int)$value;
    }
}
```

All that remains is using your `ExampleInput` class in your `Command` to validate the input.
```php
class ExampleCommand extends Command
{
    public function __construct(private InputValidator $inputValidator, ?string $name = null)
    {
        parent::__construct($name);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // third argument will throw exception if input is invalid. Set to `false` if you want to handle the validation yourself.
        $validatedInput = $this->inputValidator->validate($input, ExampleInput::class, true);
        
        ...
    }    
}
```

## Manual invalid input handling

The `validate` method will by default throw a `ViolationException`. To handle the violations yourself:
```php
class ExampleCommand extends Command
{
    ...
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $validatedInput = $this->inputValidator->validate($input, ExampleInput::class, false);
        if ($validatedInput->isValid() === false) {
            $violations = $validatedInput->getViolations();
            ...
        }
        ...
    }   
}
```


## About us

At 123inkt (Part of Digital Revolution B.V.), every day more than 50 development professionals are working on improving our internal ERP 
and our several shops. Do you want to join us? [We are looking for developers](https://www.werkenbij123inkt.nl/zoek-op-afdeling/it).
