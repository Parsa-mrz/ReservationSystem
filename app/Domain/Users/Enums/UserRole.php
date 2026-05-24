<?php
namespace App\Domain\Users\Enums;

enum UserRole: string{
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case CLIENT = 'client';
}
