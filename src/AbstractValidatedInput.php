<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractValidatedInput
{
    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $violationList
     */
    public function __construct(protected InputInterface $input, protected ConstraintViolationListInterface $violationList)
    {
    }

    public function isValid(): bool
    {
        return count($this->violationList) === 0;
    }

    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }

    /**
     * @return string[]
     */
    public function getViolationMessages(): array
    {
        $messages = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($this->violationList as $violation) {
            $messages[] = $violation->getMessage();
        }

        return $messages;
    }

    /**
     * Get all the constraints for the current input
     */
    abstract public static function getValidationRules(): ValidationRules;
}
