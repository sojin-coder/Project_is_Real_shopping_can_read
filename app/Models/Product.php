<?php

class Product extends Model
{
    protected string $table = 'products';

    // ═══════════════════════════════════════════════
    // GET ALL
    // ═══════════════════════════════════════════════
    public function all(): array
    {
        $stmt = Database::connection()->query("
            SELECT * FROM {$this->table} 
            ORDER BY id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // CREATE
    // ═══════════════════════════════════════════════
    public function create(array $data): bool
    {
        // ✅ ១. ពិនិត្យ category_id ថាមានក្នុង table categories
        $categoryId = $this->validateCategoryId($data['category_id'] ?? null);

        // ✅ ២. បង្កើត SKU ស្វ័យប្រវត្តិ ប្រសិនបើទទេ ឬស្ទួន
        $sku = trim($data['sku'] ?? '');

        if ($sku === '' || $this->skuExists($sku)) {
            $sku = $this->generateUniqueSku($data['name'] ?? 'PRD');
        }

        // ✅ ៣. បង្កើត slug ប្រសិនបើទទេ
        $slug = trim($data['slug'] ?? '');

        if ($slug === '') {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['name'] ?? ''));
            $slug = trim($slug, '-');
        }

        if ($slug === '') {
            $slug = 'product-' . bin2hex(random_bytes(6));
        }

        // ✅ ៤. ពិនិត្យ slug ស្ទួន (បន្ថែមលេខ)
        $baseSlug = $slug;
        $counter = 2;

        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $stmt = Database::connection()->prepare("
            INSERT INTO {$this->table}
            (category_id, created_by, name, slug, brand, model, sku, 
             price, condition_type, stock_status, publish_status, 
             description, is_featured)
            VALUES 
            (:category_id, :created_by, :name, :slug, :brand, :model, :sku,
             :price, :condition_type, :stock_status, :publish_status,
             :description, :is_featured)
        ");

        return $stmt->execute([
            ':category_id' => $categoryId,
            ':created_by' => $data['created_by'] ?? 1,
            ':name' => $data['name'],
            ':slug' => $slug,
            ':brand' => $data['brand'] ?? null,
            ':model' => $data['model'] ?? null,
            ':sku' => $sku,
            ':price' => $data['price'],
            ':condition_type' => $data['condition_type'] ?? 'New',
            ':stock_status' => $data['stock_status'] ?? 'Available',
            ':publish_status' => $data['publish_status'] ?? 'Draft',
            ':description' => $data['description'] ?? '',
            ':is_featured' => $data['is_featured'] ?? 0,
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
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    // ═══════════════════════════════════════════════
    // UPDATE
    // ═══════════════════════════════════════════════
    public function update($id, array $data)
    {
        $id = (int) $id;

        // ✅ ១. ពិនិត្យ category_id ថាមានក្នុង table categories
        $categoryId = $this->validateCategoryId($data['category_id'] ?? null);

        // ✅ ២. SKU: បើទទេ → យកពី DB, បើស្ទួន → បង្កើតថ្មី
        $sku = trim($data['sku'] ?? '');

        if ($sku === '') {
            $existing = $this->find($id);
            $sku = trim($existing['sku'] ?? '');

            if ($sku === '') {
                $sku = $this->generateUniqueSku($data['name'] ?? 'PRD');
            }
        } elseif ($this->skuExists($sku, $id)) {
            $sku = $this->generateUniqueSku($data['name'] ?? 'PRD');
        }

        // ✅ ៣. Slug: បើទទេ → បង្កើតពី name ឬ ID
        $slug = trim($data['slug'] ?? '');

        if ($slug === '') {
            $slug = !empty($data['name'])
                ? strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['name']))
                : 'product-' . $id;
            $slug = trim($slug, '-');
        }

        if ($slug === '') {
            $slug = 'product-' . bin2hex(random_bytes(6));
        }

        // ✅ ៤. ពិនិត្យ slug ស្ទួន (លើកលែង ID ខ្លួនឯង)
        $baseSlug = $slug;
        $counter = 2;

        while ($this->slugExists($slug, $id)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $stmt = Database::connection()->prepare("
            UPDATE {$this->table} SET
                category_id    = :category_id,
                name           = :name,
                slug           = :slug,
                brand          = :brand,
                model          = :model,
                sku            = :sku,
                price          = :price,
                condition_type = :condition_type,
                stock_status   = :stock_status,
                publish_status = :publish_status,
                description    = :description,
                is_featured    = :is_featured
            WHERE id = :id
        ");

        return $stmt->execute([
            ':category_id' => $categoryId,
            ':name' => $data['name'],
            ':slug' => $slug,
            ':brand' => $data['brand'] ?? null,
            ':model' => $data['model'] ?? null,
            ':sku' => $sku,
            ':price' => $data['price'],
            ':condition_type' => $data['condition_type'] ?? 'New',
            ':stock_status' => $data['stock_status'] ?? 'Available',
            ':publish_status' => $data['publish_status'] ?? 'Draft',
            ':description' => $data['description'] ?? '',
            ':is_featured' => $data['is_featured'] ?? 0,
            ':id' => $id,
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
    public function searchProductsWithImage(string $keyword): array
    {
        $sql = "
            SELECT
                p.id,
                p.name,
                p.brand,
                p.model,
                p.price,
                p.stock_status,
                p.publish_status,
                p.is_featured,
                c.name AS category_name,
                pi.image_path
            FROM products AS p
            LEFT JOIN categories AS c
                ON p.category_id = c.id
            LEFT JOIN product_images AS pi
                ON p.id = pi.product_id
                AND pi.is_primary = 1
            WHERE p.name LIKE :name_keyword
               OR p.brand LIKE :brand_keyword
               OR p.sku LIKE :sku_keyword
            ORDER BY p.created_at DESC
        ";

        $stmt = Database::connection()->prepare($sql);

        $searchKeyword = '%' . $keyword . '%';

        $stmt->execute([
            ':name_keyword' => $searchKeyword,
            ':brand_keyword' => $searchKeyword,
            ':sku_keyword' => $searchKeyword
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // GET ALL WITH PRIMARY IMAGE (JOIN)
    // ═══════════════════════════════════════════════
    public function getAllProducts(): array
    {
        $sql = "
            SELECT
                p.id,
                p.name,
                p.brand,
                p.model,
                p.price,
                p.stock_status,
                p.publish_status,
                p.is_featured,
                c.name AS category_name,
                c.slug AS category_slug,
                pi.image_path
            FROM products AS p
            LEFT JOIN categories AS c
                ON p.category_id = c.id
            LEFT JOIN product_images AS pi
                ON p.id = pi.product_id
                AND pi.is_primary = 1
            ORDER BY p.created_at DESC
        ";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // GET PUBLISHED BY ID (public detail)
    // ═══════════════════════════════════════════════
    public function getPublishedById(int $id): ?array
    {
        $sql = "SELECT
                    p.id,
                    p.name,
                    p.brand,
                    p.model,
                    p.sku,
                    p.price,
                    p.condition_type,
                    p.stock_status,
                    p.publish_status,
                    p.description,
                    p.is_featured,
                    c.name AS category_name
                FROM products AS p
                LEFT JOIN categories AS c
                    ON p.category_id = c.id
                WHERE p.id = :id
                  AND p.publish_status = 'Published'
                LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: null;
    }

    // ═══════════════════════════════════════════════
    // GET PRODUCT IMAGES
    // ═══════════════════════════════════════════════
    public function getProductImages(int $productId): array
    {
        $sql = "SELECT image_path, is_primary, sort_order
                FROM product_images
                WHERE product_id = :product_id
                ORDER BY is_primary DESC, sort_order ASC, id ASC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([':product_id' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // HELPER: ពិនិត្យ category_id ថាមាន
    // ═══════════════════════════════════════════════
    private function validateCategoryId($categoryId): ?int
    {
        if (empty($categoryId)) {
            return null;
        }

        $categoryId = (int) $categoryId;

        if ($categoryId < 1) {
            return null;
        }

        $stmt = Database::connection()->prepare(
            "SELECT id FROM categories WHERE id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $categoryId]);

        if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        return $categoryId;
    }

    // ═══════════════════════════════════════════════
    // HELPER: ពិនិត្យ SKU ស្ទួន
    // ═══════════════════════════════════════════════
    private function skuExists(string $sku, ?int $excludeId = null): bool
    {
        if ($sku === '')
            return false;

        $sql = "SELECT id FROM {$this->table} WHERE sku = :sku";
        $params = [':sku' => $sku];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $sql .= " LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // HELPER: ពិនិត្យ Slug ស្ទួន
    // ═══════════════════════════════════════════════
    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($slug === '')
            return false;

        $sql = "SELECT id FROM {$this->table} WHERE slug = :slug";
        $params = [':slug' => $slug];

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $sql .= " LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ═══════════════════════════════════════════════
    // HELPER: បង្កើត SKU ស្វ័យប្រវត្តិ
    // ═══════════════════════════════════════════════
    private function generateUniqueSku(string $name): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
        if ($prefix === '') {
            $prefix = 'PRD';
        }

        do {
            $sku = $prefix . '-' . strtoupper(bin2hex(random_bytes(3)));
        } while ($this->skuExists($sku));

        return $sku;
    }
}