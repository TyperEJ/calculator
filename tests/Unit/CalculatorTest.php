<?php

namespace Tests\Unit;

use App\Services\CalculateException;
use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculatorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculatorService = new Calculator();
    }

    public function test_add(): void
    {
        $result = $this->calculatorService->evaluate('1+1');

        $this->assertEquals(2, $result);
    }

    public function test_div(): void
    {
        $result = $this->calculatorService->evaluate('2/2');

        $this->assertEquals(1, $result);
    }

    public function test_mul(): void
    {
        $result = $this->calculatorService->evaluate('2x2');

        $this->assertEquals(4, $result);
    }

    public function test_sub(): void
    {
        $result = $this->calculatorService->evaluate('2-2');

        $this->assertEquals(0, $result);
    }

    public function test_mul_is_greater(): void
    {
        $result = $this->calculatorService->evaluate('1+2x3');

        $this->assertEquals(7, $result);
    }

    public function test_brackets_is_greater(): void
    {
        $result = $this->calculatorService->evaluate('(1+2)x3');

        $this->assertEquals(9, $result);
    }

    public function test_div_is_zero(): void
    {
        $this->expectException(CalculateException::class);
        $this->expectExceptionMessage('The divisor cannot be zero.');

        $this->calculatorService->evaluate('10/0');
    }

    public function test_complex_expression(): void
    {
        $result = $this->calculatorService->evaluate('5+((1+2)x3)');

        $this->assertEquals(14, $result);
    }
}
