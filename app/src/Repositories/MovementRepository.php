<?php

namespace App\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MovementRepository
{
    private Connection $conn;

    public function __construct()
    {
        $this->conn = self::createConnection();
    }

    public function findMovement(string $movementInput): ?array
    {
        if (is_numeric($movementInput)) {
            return $this->conn->fetchAssociative('SELECT id, name FROM movement WHERE id = ?', [$movementInput]);
        }
        
        return $this->conn->fetchAssociative(
            'SELECT id, name FROM movement WHERE LOWER(name) LIKE LOWER(?)',
            ['%' . $movementInput . '%']
        );
    }

    public function fetchPersonalRecords(int $movementId): array
    {
        $sql = "SELECT 
            u.name AS user_name, 
            pr.value, 
            pr.date
            FROM personal_record pr
            INNER JOIN user u ON pr.user_id = u.id
            INNER JOIN (
                SELECT user_id, MAX(value) AS max_value
                FROM personal_record
                WHERE movement_id = ?
                GROUP BY user_id
            ) max_pr ON pr.user_id = max_pr.user_id AND pr.value = max_pr.max_value
            WHERE pr.movement_id = ?
            ORDER BY pr.value DESC, pr.date ASC
        ";

        return $this->conn->fetchAllAssociative($sql, [$movementId, $movementId]);
    }

    private static function createConnection(): Connection
    {
        return DriverManager::getConnection(self::getConnectionParams());
    }

    private static function getConnectionParams(): array
    {
        return [
            'dbname'   => $_ENV['DB_NAME']   ?? 'homestead',
            'user'     => $_ENV['DB_USER']   ?? 'dev',
            'password' => $_ENV['DB_PASSWORD'] ?? 'dev',
            'host'     => $_ENV['DB_HOST']   ?? 'mysql',
            'driver'   => 'pdo_mysql',
            'charset'  => 'utf8mb4',
        ];
    }

}
