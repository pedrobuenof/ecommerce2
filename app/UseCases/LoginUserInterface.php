<?php

namespace App\UseCases;


interface LoginUserInterface
{
    public function isValid(array $loginDataValid): array;
}
