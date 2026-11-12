<?php

require_once __DIR__ . '/Model.php';

class StoreSetting extends Model
{
    protected string $table = 'settings';

    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table}"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}