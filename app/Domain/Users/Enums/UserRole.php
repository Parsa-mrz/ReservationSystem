<?php
namespace App\Domain\Users\Enums;

enum UserRole: string{
    case ADMIN = 'admin';
    case Owner = 'owner';
    case Client = 'client';
}
