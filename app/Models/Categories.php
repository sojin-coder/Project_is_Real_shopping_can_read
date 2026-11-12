<?php


class Categories extends Model
{
    protected string $table = 'categories';

    // ═══════════════════════════════════════════════
    // GET ALL
    // ═══════════════════════════════════════════════
    public function all(): array
    {
        $stmt = Database::connection()->query("
            SELECT * FROM {$this->table} ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // CREATE — ត្រូវនឹង categories table
    // ═══════════════════════════════════════════════
    public function create(array $data): bool
    {
        $stmt = Database::connection()->prepare("
            INSERT INTO {$this->table}
            (name, slug, description)
            VALUES (:name, :slug, :description)
        ");

        return $stmt->execute([
            ':name'        => $data['name'],
            ':slug'        => $data['slug']        ?? '',
            ':description' => $data['description'] ?? '',
        ]);
    }

    // ═══════════════════════════════════════════════
    // FIND BY ID
    // ═══════════════════════════════════════════════
    public function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare("
            SELECT * FROM {$this->table} WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null;
    }

    // ═══════════════════════════════════════════════
    // UPDATE — ខ្វះ comma នៅកូដចាស់
    // ═══════════════════════════════════════════════
    public function update(int $id, array $data): bool
    {
        $stmt = Database::connection()->prepare("
            UPDATE {$this->table}
            SET
                name        = :name,
                slug        = :slug,
                description = :description
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'          => $id,
            ':name'        => $data['name'],
            ':slug'        => $data['slug']        ?? '',
            ':description' => $data['description'] ?? '',
        ]);
    }

    // ═══════════════════════════════════════════════
    // DELETE
    // ═══════════════════════════════════════════════
    public function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare("
            DELETE FROM {$this->table} WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    // ═══════════════════════════════════════════════
    // SEARCH
    // ═══════════════════════════════════════════════
    public function search(string $keyword): array
    {
        $stmt = Database::connection()->prepare("
            SELECT * FROM {$this->table} 
            WHERE name LIKE :keyword 
               OR slug LIKE :keyword
            ORDER BY id DESC
        ");

        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // រាប់ Products ក្នុង Category
    // ═══════════════════════════════════════════════
    public function countProducts(int $id): int
    {
        $stmt = Database::connection()->prepare("
            SELECT COUNT(*) FROM products WHERE category_id = :id
        ");
        $stmt->execute([':id' => $id]);
        return (int) $stmt->fetchColumn();
    }
}