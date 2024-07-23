<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Connection;
use App\Interface\Repository\BaseRepositoryInterface;
use PDO;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Connection|PDO $connection;
    protected string $tableName;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    /**
     * @return string
     */
    private function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    protected function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @return array|false
     */
    protected function getAll(): false|array
    {
        $stmt = $this->connection->query('SELECT * FROM ' . $this->getTableName());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return mixed
     */
    protected function getById(int $id): mixed
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function create(array $data): false|string
    {
        $keys = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $stmt = $this->connection->prepare('INSERT INTO ' . $this->getTableName() . " ($keys) VALUES ($values)");
        $stmt->execute($data);
        return $this->connection->lastInsertId();
    }

    /**
     * @param array $data
     * @param array $criteria
     * @return array
     */
    public function updateByCriteria(array $data, array $criteria): array
    {
        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "$key = :set_$key";
        }
        $setClause = implode(', ', $setClauses);

        $whereClauses = [];
        $params = [];
        foreach ($criteria as $key => $value) {
            if ($value === null) {
                $whereClauses[] = "$key IS NULL";
            } else {
                $whereClauses[] = "$key = :where_$key";
                $params[":where_$key"] = $value;
            }
        }
        foreach ($data as $key => $value) {
            $params[":set_$key"] = $value;
        }
        $whereClause = implode(' AND ', $whereClauses);

        $query = "UPDATE {$this->getTableName()} SET $setClause WHERE $whereClause";

        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Обновление успешно выполнено', 'status' => 200];
            } else {
                return ['success' => false, 'message' => 'Ничего не обновлено', 'status' => 404];
            }
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Ошибка при выполнении обновления: ' . $e->getMessage(), 'status' => 500];
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM ' . $this->getTableName() . ' WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    /**
     * @param array $criteria
     * @return bool
     */
    public function deleteByCriteria(array $criteria): bool
    {
        $conditions = [];
        foreach ($criteria as $key => $value) {
            if ($value === null) {
                $conditions[] = "$key IS NULL";
            } else {
                $conditions[] = "$key = :$key";
            }
        }
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE ' . implode(' AND ', $conditions);
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(array_filter($criteria, fn($value) => $value !== null));
    }

    /**
     * @param array $criteria
     * @param string $field
     * @return bool|int
     */
    protected function findByCriteria(array $criteria, string $field): bool|int
    {
        $sql = "SELECT $field FROM " . $this->getTableName() . " WHERE ";
        $conditions = [];
        $params = [];

        foreach ($criteria as $key => $value) {
            if ($value === null or $value == 0) {
                $conditions[] = "$key IS NULL";
            } else {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        $sql .= implode(' AND ', $conditions);

        $stmt = Connection::getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }
}