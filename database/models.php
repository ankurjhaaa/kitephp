<?php

namespace Database;

use Kite\Core\Model;
use Kite\Core\Schema\Field;

// Define your Django-style models here.

class User extends Model 
{
    public static function fields(): array 
    {
        return [
            'name' => Field::string(['max_length' => 255]),
            'email' => Field::string(['max_length' => 255, 'unique' => true]),
        ];
    }
}
