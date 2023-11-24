<?php

namespace App\Services;

interface InterfaceCalculator
{
    public function evaluate(string $calculation): mixed;
}
