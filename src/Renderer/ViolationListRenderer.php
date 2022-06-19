<?php
declare(strict_types=1);

namespace DigitalRevolution\SymfonyInputValidation\Renderer;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListRenderer extends Output
{
    public function __construct(private OutputInterface $output)
    {
    }

    /**
     * ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function render(ConstraintViolationListInterface $violations): void
    {
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $this->output->writeln("- " . $violation->getMessage());
        }
    }
}
