<?php

namespace Kite\Core;

class Migrator
{
    /**
     * Reads database/models.php, compares with .schema.json, and generates migration if needed.
     */
    public static function makeMigrations()
    {
        $modelsFile = dirname(__DIR__) . '/database/models.php';
        if (!file_exists($modelsFile)) {
            echo "Error: database/models.php not found.\n";
            return;
        }

        require_once $modelsFile;
        
        $classes = get_declared_classes();
        $models = [];
        foreach ($classes as $class) {
            if (is_subclass_of($class, Model::class)) {
                $models[] = $class;
            }
        }

        // Build current schema array
        $currentSchema = [];
        foreach ($models as $model) {
            $table = $model::tableName();
            $fields = $model::getSchema();
            foreach ($fields as $name => $field) {
                $currentSchema[$table][$name] = $field->toSql();
            }
        }

        // Load previous schema
        $schemaFile = dirname(__DIR__) . '/database/migrations/.schema.json';
        $previousSchema = [];
        if (file_exists($schemaFile)) {
            $previousSchema = json_decode(file_get_contents($schemaFile), true) ?: [];
        }

        if ($currentSchema === $previousSchema) {
            echo "No changes detected.\n";
            return;
        }

        $sqlStatements = [];
        $actionNames = [];

        // 1. Check for new tables and column changes
        foreach ($currentSchema as $table => $columns) {
            if (!isset($previousSchema[$table])) {
                // New Table
                $cols = [];
                foreach ($columns as $name => $sqlDef) {
                    $cols[] = "`{$name}` {$sqlDef}";
                }
                $sqlStatements[] = "CREATE TABLE IF NOT EXISTS `{$table}` (\n    " . implode(",\n    ", $cols) . "\n);";
                $actionNames[] = "create_{$table}_table";
            } else {
                // Existing Table, check for new/modified columns
                $tableAction = '';
                foreach ($columns as $name => $sqlDef) {
                    if (!isset($previousSchema[$table][$name])) {
                        $sqlStatements[] = "ALTER TABLE `{$table}` ADD COLUMN `{$name}` {$sqlDef};";
                        if (!$tableAction) $tableAction = "add_{$name}_to_{$table}";
                    } elseif ($previousSchema[$table][$name] !== $sqlDef) {
                        $sqlStatements[] = "ALTER TABLE `{$table}` MODIFY COLUMN `{$name}` {$sqlDef};";
                        if (!$tableAction) $tableAction = "alter_{$name}_in_{$table}";
                    }
                }
                // Check for deleted columns
                foreach ($previousSchema[$table] as $name => $sqlDef) {
                    if (!isset($columns[$name])) {
                        $sqlStatements[] = "ALTER TABLE `{$table}` DROP COLUMN `{$name}`;";
                        if (!$tableAction) $tableAction = "drop_{$name}_from_{$table}";
                    }
                }
                if ($tableAction) {
                    $actionNames[] = $tableAction;
                }
            }
        }

        // 2. Check for deleted tables
        foreach ($previousSchema as $table => $columns) {
            if (!isset($currentSchema[$table])) {
                $sqlStatements[] = "DROP TABLE IF EXISTS `{$table}`;";
                $actionNames[] = "drop_{$table}_table";
            }
        }

        if (empty($sqlStatements)) {
            echo "No changes detected.\n";
            return;
        }

        // Determine migration suffix based on actions
        if (count($actionNames) === 1) {
            $suffix = '_' . $actionNames[0];
        } elseif (count($actionNames) > 1) {
            $suffix = '_multiple_schema_changes';
        } else {
            $suffix = '_schema';
        }

        // Generate migration file
        $migrationName = date('Ymd_His') . $suffix . '.php';
        $migrationDir = dirname(__DIR__) . '/database/migrations';
        if (!is_dir($migrationDir)) {
            mkdir($migrationDir, 0755, true);
        }
        
        $migrationFile = $migrationDir . '/' . $migrationName;
        
        $content = "<?php\n\n// Auto-generated Smart Migration\n\nreturn [\n";
        foreach ($sqlStatements as $sql) {
            $escapedSql = addcslashes($sql, '"\\$');
            $content .= "    \"{$escapedSql}\",\n";
        }
        $content .= "];\n";
        
        file_put_contents($migrationFile, $content);
        file_put_contents($schemaFile, json_encode($currentSchema, JSON_PRETTY_PRINT));
        
        echo "Created migration: {$migrationName}\n";
    }

    /**
     * Runs all pending migrations against the database.
     */
    public static function migrate()
    {
        try {
            $db = Database::connect();
        } catch (\Exception $e) {
            echo "Database connection failed: " . $e->getMessage() . "\n";
            return;
        }
        
        $db->exec("CREATE TABLE IF NOT EXISTS _migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $stmt = $db->query("SELECT migration FROM _migrations");
        $runMigrations = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        
        $migrationFiles = glob(dirname(__DIR__) . '/database/migrations/*.php');
        sort($migrationFiles);
        
        $migratedAny = false;
        
        foreach ($migrationFiles as $file) {
            $filename = basename($file);
            if (!in_array($filename, $runMigrations)) {
                echo "Applying migration: {$filename}...\n";
                
                $queries = require $file;
                foreach ($queries as $query) {
                    $db->exec($query);
                }
                
                $stmt = $db->prepare("INSERT INTO _migrations (migration) VALUES (?)");
                $stmt->execute([$filename]);
                
                $migratedAny = true;
                echo "Successfully applied: {$filename}\n";
            }
        }
        
        if (!$migratedAny) {
            echo "No pending migrations found.\n";
        }
    }
}
