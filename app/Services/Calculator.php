<?php

namespace App\Services;

use Illuminate\Support\Arr;

class Calculator implements InterfaceCalculator
{
    private array $operators = ['+', '-', 'x', '/'];

    public function evaluate(string $calculation): mixed
    {
        $separatedExpression = $this->separateExpression($calculation);

        $postfix = $this->infixToPostfix($separatedExpression);

        return $this->evaluatePostfix($postfix);
    }

    private function separateExpression(string $calculation): array
    {
        preg_match_all("/(\d+|[\+\-\/x\/\(\)])/", $calculation, $matches);

        return Arr::first($matches);
    }

    private function infixToPostfix(array $expressions): array
    {
        $output = [];
        $stack = collect();

        foreach ($expressions as $unit) {
            if (in_array($unit, $this->operators)) {
                while ($stack->isNotEmpty() && $this->isPrecedenceGreater($stack->last(), $unit)) {
                    $output[] = $stack->pop();
                }
                $stack->push($unit);
            } elseif ($unit == '(') {
                $stack->push($unit);
            } elseif ($unit == ')') {
                while ($stack->isNotEmpty() && $stack->last() != '(') {
                    $output[] = $stack->pop();
                }
                $stack->pop();
            } else {
                $output[] = $unit;
            }
        }

        while ($stack->isNotEmpty()) {
            $output[] = $stack->pop();
        }

        return $output;
    }

    private function evaluatePostfix(array $postfix): mixed
    {
        $stack = collect();

        foreach ($postfix as $unit) {
            if (is_numeric($unit)) {
                $stack->push($unit);
            } elseif (in_array($unit, $this->operators)) {
                $numberB = $stack->pop();
                $numberA = $stack->pop();

                switch ($unit) {
                    case '+':
                        $stack->push($numberA + $numberB);
                        break;
                    case '-':
                        $stack->push($numberA - $numberB);
                        break;
                    case 'x':
                        $stack->push($numberA * $numberB);
                        break;
                    case '/':
                        if ($numberB == 0) {
                            throw new CalculateException('The divisor cannot be zero.');
                        }

                        $stack->push($numberA / $numberB);
                        break;
                }
            }
        }

        return $stack->first();
    }

    private function isPrecedenceGreater(string $operatorA, string $operatorB): bool
    {
        $precedence = ['(' => 0, '+' => 1, '-' => 1, 'x' => 2, '/' => 2];

        return $precedence[$operatorA] >= $precedence[$operatorB];
    }
}
