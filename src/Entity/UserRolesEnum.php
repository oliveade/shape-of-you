<?php

namespace App\Entity;

enum UserRolesEnum: string
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
}