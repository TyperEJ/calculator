<?php

namespace App\Console\Commands;

use App\Services\InterfaceCalculator;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

class Calculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculator';

    /**
     * Execute the console command.
     */
    public function handle(InterfaceCalculator $calculator): int
    {
        $calculation = text(
            label: 'Please enter your calculation'
        );

        if (! $this->isValidExpression($calculation)) {
            $this->error('Please check your formula. We only allow numbers and symbols +-x/().');

            return Command::INVALID;
        }

        $result = $calculator->evaluate($calculation);

        $this->info("The answer to this equation is $result");

        return Command::SUCCESS;
    }

    private function isValidExpression(string $calculation): bool
    {
        return (bool) preg_match('/^[\d\+\-\/x\/\(\)]+$/', $calculation);
    }
}
