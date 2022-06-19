<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ViolationException extends Exception
{
    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $violations
     */
    public function __construct(private ConstraintViolationListInterface $violations, int $code = 0, ?Throwable $previous = null)
    {
        $messages = [];
        foreach ($this->violations as $violation) {
            $messages[] = $violation->getMessage();
        }

        parent::__construct(implode("\n", $messages), $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
