<?php

namespace Kite\Core;

use PDO;

class QueryBuilder
{
    protected PDO $pdo;
    protected string $table;
    protected array $select = ['*'];
    protected array $wheres = [];
    protected array $bindings = [];
    protected string $orderBy = '';
    protected string $limit = '';

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function select(...$columns): self
    {
        $this->select = is_array($columns[0]) ? $columns[0] : $columns;
        return $this;
    }

    public function where(string $column, $operator, $value = null): self
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('column', 'operator', 'value');
        $this->bindings[] = $value;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    protected function buildSelectQuery(): string
    {
        $query = "SELECT " . implode(', ', $this->select) . " FROM {$this->table}";

        if (!empty($this->wheres)) {
            $conditions = [];
            foreach ($this->wheres as $where) {
                $conditions[] = "{$where['column']} {$where['operator']} ?";
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $query .= $this->orderBy . $this->limit;

        return $query;
    }

    public function get(): array
    {
        $stmt = $this->pdo->prepare($this->buildSelectQuery());
        $stmt->execute($this->bindings);
        return $stmt->fetchAll();
    }

    public function first()
    {
        $this->limit(1);
        $stmt = $this->pdo->prepare($this->buildSelectQuery());
        $stmt->execute($this->bindings);
        return $stmt->fetch() ?: null;
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($data), '?');

        $query = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($data));

        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $data): int
    {
        $columns = array_keys($data);
        $sets = array_map(fn($col) => "{$col} = ?", $columns);

        $query = "UPDATE {$this->table} SET " . implode(', ', $sets);
        
        $bindings = array_values($data);

        if (!empty($this->wheres)) {
            $conditions = [];
            foreach ($this->wheres as $where) {
                $conditions[] = "{$where['column']} {$where['operator']} ?";
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
            $bindings = array_merge($bindings, $this->bindings);
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($bindings);

        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $query = "DELETE FROM {$this->table}";

        if (!empty($this->wheres)) {
            $conditions = [];
            foreach ($this->wheres as $where) {
                $conditions[] = "{$where['column']} {$where['operator']} ?";
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->bindings);

        return $stmt->rowCount();
    }
}
