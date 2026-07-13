<?php

namespace Database;

use Kite\Core\Model;
use Kite\Core\Schema\Field;

// Define your Django-style models here.

class User extends Model 
{
    public static string $table = 'users';

    public static function fields(): array 
    {
        return [
            'name' => Field::string(['max_length' => 255]),
            'email' => Field::string(['max_length' => 255, 'unique' => true]),
            'password' => Field::string(['max_length' => 255]),
            // RBAC Fields
            'is_superuser' => Field::integer(['default' => 0]),
            'is_staff' => Field::integer(['default' => 0]),
        ];
    }
}

class AuthGroup extends Model 
{
    public static string $table = 'auth_groups';
    
    public static function fields(): array 
    {
        return [
            'name' => Field::string(['max_length' => 150, 'unique' => true]),
        ];
    }
}

class AuthPermission extends Model 
{
    public static string $table = 'auth_permissions';
    
    public static function fields(): array 
    {
        return [
            'name' => Field::string(['max_length' => 255]),
            'codename' => Field::string(['max_length' => 100, 'unique' => true]),
        ];
    }
}

class AuthGroupPermission extends Model 
{
    public static string $table = 'auth_group_permissions';
    
    public static function fields(): array 
    {
        return [
            'group_id' => Field::foreignId('auth_groups', 'id', ['onDelete' => 'CASCADE']),
            'permission_id' => Field::foreignId('auth_permissions', 'id', ['onDelete' => 'CASCADE']),
        ];
    }
}

class AuthUserGroup extends Model 
{
    public static string $table = 'auth_user_groups';
    
    public static function fields(): array 
    {
        return [
            'user_id' => Field::foreignId('users', 'id', ['onDelete' => 'CASCADE']),
            'group_id' => Field::foreignId('auth_groups', 'id', ['onDelete' => 'CASCADE']),
        ];
    }
}

class AuthUserPermission extends Model 
{
    public static string $table = 'auth_user_permissions';
    
    public static function fields(): array 
    {
        return [
            'user_id' => Field::foreignId('users', 'id', ['onDelete' => 'CASCADE']),
            'permission_id' => Field::foreignId('auth_permissions', 'id', ['onDelete' => 'CASCADE']),
        ];
    }
}
