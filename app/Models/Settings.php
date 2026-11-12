
<?php

class Settings extends Model
{
    protected string $table = 'settings';

    // Get all settings
    public function all(): array
    {
        $stmt = Database::connection()->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create setting
    public function create(array $data): bool
    {
        $stmt = Database::connection()->prepare("
            INSERT INTO {$this->table}
                (setting_key, setting_value, updated_at)
            VALUES
                (:setting_key, :setting_value, :updated_at)
        ");

        return $stmt->execute([
            'setting_key' => $data['setting_key'],
            'setting_value' => $data['setting_value'],
            'updated_at' => $data['updated_at']
        ]);
    }

    // Find setting by ID
    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare("
            SELECT *
            FROM {$this->table}
            WHERE id = :id
        ");

        $stmt->execute(['id' => $id]);

        $setting = $stmt->fetch(PDO::FETCH_ASSOC);

        return $setting ?: null;
    }

    // Update setting
    public function update(int $id, array $data): bool
    {
        $stmt = Database::connection()->prepare("
            UPDATE {$this->table}
            SET
                setting_key = :setting_key,
                setting_value = :setting_value,
                updated_at = :updated_at
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'setting_key' => $data['setting_key'],
            'setting_value' => $data['setting_value'],
            'updated_at' => $data['updated_at']
        ]);
    }

    // Delete setting
    public function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare("
            DELETE FROM {$this->table}
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }

    // Search settings by key or value
    public function search(string $keyword): array
    {
        $stmt = Database::connection()->prepare("
            SELECT *
            FROM {$this->table}
            WHERE setting_key LIKE :keyword
               OR setting_value LIKE :keyword
            ORDER BY id DESC
        ");

        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
