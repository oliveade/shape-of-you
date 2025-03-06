<?php

namespace App\Entity;

enum PieceBodyTypeEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}
