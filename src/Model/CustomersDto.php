<?php

namespace App\Model;

final class CustomersDto
{
    /**
     * @param UserDto[] $users
     */
    public function __construct(
        public readonly array $users = []
    )
    {
    }
}