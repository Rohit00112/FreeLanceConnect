<?php

namespace App\Enums;

enum UserRole: string{
     case ADMIN = 'admin';
     case FREELANCER = 'freelancer';
     case CLIENT = 'client';

     public function label(): string{
          return match ($this) {
               self::ADMIN => 'Admin',
               self::FREELANCER => 'Freelancer',
               self::CLIENT => 'Client',
          };
     }
}