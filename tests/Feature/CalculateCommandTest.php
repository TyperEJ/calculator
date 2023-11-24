<?php

namespace Tests\Feature;

use Psy\Command\Command;
use Tests\TestCase;

class CalculateCommandTest extends TestCase
{
    public function test_calculate_command_error_type(): void
    {
        $this->artisan('calculate')
            ->expectsQuestion('Please enter your calculation', '1+1@3')
            ->expectsOutput('Please check your formula. We only allow numbers and symbols +-x/().')
            ->assertExitCode(Command::INVALID);
    }

    public function test_calculate_command(): void
    {
        $this->artisan('calculate')
            ->expectsQuestion('Please enter your calculation', '(1+2)x3')
            ->expectsOutput('The answer to this equation is 9')
            ->assertOk();
    }
}
