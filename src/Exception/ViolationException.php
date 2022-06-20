<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyConsoleValidation\Exception;

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
        /** @var ConstraintViolationInterface $violation */
        foreach ($this->violations as $violation) {
            $messages[] = sprintf(
                '%s: %s. Value given `%s`.',
                str_replace(['[', ']'], '', $violation->getPropertyPath()),
                $violation->getMessage(),
                is_scalar($violation->getInvalidValue()) ? $violation->getInvalidValue() : 'mixed'
            );
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
