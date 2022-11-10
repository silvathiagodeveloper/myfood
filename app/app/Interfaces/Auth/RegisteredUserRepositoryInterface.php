<?php

namespace App\Interfaces\Auth;

interface RegisteredUserRepositoryInterface
{
    public function register(array $data);
}