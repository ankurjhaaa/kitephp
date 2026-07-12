<?php

namespace Kite\Core;

use Kite\Core\Schema\Field;

abstract class Model
{
    /**
     * Get the database table name associated with the model.
     * Defaults to the pluralized class name (e.g. User -> users).
     */
    public static function tableName(): string
    {
        $path = explode('\\', static::class);
        $name = strtolower(array_pop($path));
        
        // Simple pluralization (add 's' unless it already ends in 's')
        if (substr($name, -1) !== 's') {
            $name .= 's';
        }
        
        return $name;
    }

    /**
     * Get the full schema including auto-injected fields.
     */
    public static function getSchema(): array
    {
        $fields = static::fields();

        if (!isset($fields['id'])) {
            $fields = array_merge(
                ['id' => Field::integer(['primary_key' => true, 'auto_increment' => true])],
                $fields
            );
        }

        if (!isset($fields['created_at'])) {
            $fields['created_at'] = Field::timestamp(['default' => 'CURRENT_TIMESTAMP']);
        }

        if (!isset($fields['updated_at'])) {
            $fields['updated_at'] = Field::timestamp(['default' => 'CURRENT_TIMESTAMP', 'nullable' => true]);
        }

        return $fields;
    }
    abstract public static function fields(): array;

    /**
     * Get a query builder instance for this model's table.
     * Usage: User::objects()->where(...)->get();
     */
    public static function objects(): QueryBuilder
    {
        return Database::table(static::tableName());
    }
}
