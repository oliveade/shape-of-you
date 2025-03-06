<?php

namespace App\Entity;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}
