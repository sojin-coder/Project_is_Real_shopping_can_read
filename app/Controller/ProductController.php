<?php
require_once __DIR__ . '/../Models/StoreSetting.php';

class ProductController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    // ═══════════════════════════════════════════════
    // បង្ហាញបញ្ជីផលិតផល
    // ═══════════════════════════════════════════════
    public function index()
    {
        $productModel = new Product();
        $products = $productModel->getAllProducts();
        // ⭐ បន្ថែម - ទាញ settings សម្រាប់ logo
        $settingsByKey = [];
        try {
            $settings = Database::query("SELECT * FROM settings")->fetchAll();
            foreach ($settings as $item) {
                $settingsByKey[$item['setting_key']] = $item;
            }
        } catch (Exception $e) {
            $settingsByKey = [];
        }

        $this->view('product/index', [
            'title' => 'Products',
            'active' => 'products',
            'products' => $products,
            'settingsByKey' => $settingsByKey,
        ]);

    }

    // ═══════════════════════════════════════════════
    // បង្ហាញ Form បន្ថែម
    // ═══════════════════════════════════════════════
    public function create()
    {
        $categories = Database::query("SELECT * FROM categories ORDER BY name")->fetchAll();

        $this->view('product/create', [
            'title' => 'Add Product',
            'active' => 'products',
            'categories' => $categories,
        ]);
    }

    // ═══════════════════════════════════════════════
    // រក្សាទុកផលិតផលថ្មី
    // ═══════════════════════════════════════════════
    public function store()
    {
        $productModel = new Product();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');

        if ($slug === '') {
            $slug = strtolower($name);
            $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
            $slug = trim($slug, '-');
        }

        if ($slug === '') {
            $slug = 'product-' . bin2hex(random_bytes(6));
        }

        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = trim($slug, '-');

        if ($slug === '') {
            $slug = 'product-' . bin2hex(random_bytes(6));
        }

        $baseSlug = $slug;
        $counter = 2;

        while (true) {
            $stmt = Database::connection()->prepare(
                "SELECT id FROM products WHERE slug = :slug LIMIT 1"
            );
            $stmt->execute(['slug' => $slug]);

            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                break;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $data = [
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'created_by' => $_SESSION['admin_id'] ?? 1,
            'name' => $name,
            'slug' => $slug,
            'brand' => trim($_POST['brand'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'sku' => trim($_POST['sku'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'condition_type' => $_POST['condition_type'] ?? 'New',
            'stock_status' => $_POST['stock_status'] ?? 'Available',
            'publish_status' => $_POST['publish_status'] ?? 'Draft',
            'description' => trim($_POST['description'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        ];

        $productModel->create($data);
        $productId = (int) Database::connection()->lastInsertId();

        if (isset($_FILES['images'])) {
            $uploadDir = __DIR__ . '/../../public/assets/uploads/products/';
            $urlPath = 'assets/uploads/products/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            $images = $_FILES['images'];
            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];

            $sortOrder = 0;
            $hasPrimary = false;
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);

            foreach ($images['name'] as $index => $imageName) {
                if ($images['error'][$index] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpPath = $images['tmp_name'][$index];
                $mimeType = $fileInfo->file($tmpPath);

                if (!isset($allowedTypes[$mimeType])) {
                    continue;
                }

                $extension = $allowedTypes[$mimeType];
                $filename = uniqid('prod_', true)
                    . '_' . bin2hex(random_bytes(4))
                    . '.' . $extension;

                if (move_uploaded_file($tmpPath, $uploadDir . $filename)) {
                    $isPrimary = $hasPrimary ? 0 : 1;

                    Database::query(
                        "INSERT INTO product_images
                        (product_id, image_path, is_primary, sort_order)
                        VALUES (?, ?, ?, ?)",
                        [$productId, $urlPath . $filename, $isPrimary, $sortOrder]
                    );

                    $hasPrimary = true;
                    $sortOrder++;
                }
            }
        }

        $_SESSION['success'] = 'បន្ថែមផលិតផលបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/products');
        exit;
    }

    // ═══════════════════════════════════════════════
    // បង្ហាញ Form កែ
    // ═══════════════════════════════════════════════
    public function edit($id = null)
    {
        if ($id === null) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid product ID.';
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            $_SESSION['error'] = 'រកមិនឃើញផលិតផលនេះ!';
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        $images = Database::query("
            SELECT * FROM product_images
            WHERE product_id = ?
            ORDER BY is_primary DESC, sort_order ASC
        ", [$id])->fetchAll();

        $categories = Database::query("SELECT * FROM categories ORDER BY name")->fetchAll();

        $this->view('product/edit', [
            'title' => 'Edit Product',
            'active' => 'products',
            'product' => $product,
            'images' => $images,
            'categories' => $categories,
        ]);
    }

    // ═══════════════════════════════════════════════
    // Update
    // ═══════════════════════════════════════════════
    // ═══════════════════════════════════════════════
    // Update
    // ═══════════════════════════════════════════════
    public function update($id = null)
    {
        // គាំទ្រទាំង /products/update/27 និង /products/update?id=27
        if ($id === null) {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)
                ?: filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid product ID.';
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        $productModel = new Product();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');

        // បង្កើត slug ប្រសិនបើទទេ
        if ($slug === '') {
            $slug = strtolower($name);
            $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
            $slug = trim($slug, '-');
        }

        if ($slug === '') {
            $slug = 'product-' . bin2hex(random_bytes(6));
        }

        // ✅ ១. ត្រួតពិនិត្យ stock_status ឱ្យត្រូវតាម CHECK constraint
        $allowedStock = ['Available', 'Out of Stock', 'Pre-order'];
        $stockStatus = trim($_POST['stock_status'] ?? '');
        if (!in_array($stockStatus, $allowedStock, true)) {
            $stockStatus = 'Available'; // បើខុស ឬទទេ បង្ខំឱ្យប្រើ Available
        }

        // ✅ ២. ត្រួតពិនិត្យ condition_type
        $allowedCondition = ['New', 'Used', 'Refurbished'];
        $conditionType = trim($_POST['condition_type'] ?? '');
        if (!in_array($conditionType, $allowedCondition, true)) {
            $conditionType = 'New';
        }

        // ✅ ៣. ត្រួតពិនិត្យ publish_status
        $allowedPublish = ['Draft', 'Published', 'Archived'];
        $publishStatus = trim($_POST['publish_status'] ?? '');
        if (!in_array($publishStatus, $allowedPublish, true)) {
            $publishStatus = 'Draft';
        }

        // រៀបចំទិន្នន័យ
        $data = [
            'category_id' => (int) ($_POST['category_id'] ?? 0) ?: null,
            'name' => $name,
            'slug' => $slug,
            'brand' => trim($_POST['brand'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'sku' => trim($_POST['sku'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'condition_type' => $conditionType,
            'stock_status' => $stockStatus,
            'publish_status' => $publishStatus,
            'description' => trim($_POST['description'] ?? ''),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        ];

        // Update ចូល Database
        $productModel->update($id, $data);

        // Upload រូបភាពថ្មី (បើមាន)
        if (!empty($_FILES['image']['name'])) {
            $this->handleSingleImageUpload($id, $_FILES['image']);
        }

        $_SESSION['success'] = 'កែផលិតផលបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/products');
        exit;
    }
    // Helper សម្រាប់ Upload រូបភាពពេល Update
    private function handleSingleImageUpload(int $productId, array $image): void
    {
        $uploadDir = __DIR__ . '/../../public/assets/uploads/products/';
        $urlPath = 'assets/uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return;
        }

        $filename = uniqid('prod_') . '_' . time() . '.' . $ext;

        if (move_uploaded_file($image['tmp_name'], $uploadDir . $filename)) {
            // ព្យាយាម Update រូបភាពដែលជា Primary
            $updated = Database::query("
                UPDATE product_images
                SET image_path = ?
                WHERE product_id = ? AND is_primary = 1
            ", [$urlPath . $filename, $productId])->rowCount();

            // ប្រសិនបើគ្មានរូបភាព Primary ទេ ឱ្យ Insert ថ្មី
            if ($updated === 0) {
                Database::query("
                    INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
                    VALUES (?, ?, 1, 0)
                ", [$productId, $urlPath . $filename]);
            }
        }
    }

    // ═══════════════════════════════════════════════
    // លុប
    // ═══════════════════════════════════════════════
    public function delete($id = null)
    {
        // ✅ គាំទ្រទាំង /delete/1 និង /delete?id=1
        if ($id === null) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
                ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid product ID.';
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        $productModel = new Product();

        $images = Database::query("
            SELECT image_path FROM product_images WHERE product_id = ?
        ", [$id])->fetchAll();

        foreach ($images as $img) {
            $file = __DIR__ . '/../../public/' . $img['image_path'];
            if (file_exists($file)) {
                unlink($file);
            }
        }

        Database::query("DELETE FROM product_images WHERE product_id = ?", [$id]);
        $productModel->delete($id);

        $_SESSION['success'] = 'លុបផលិតផលបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/products');
        exit;
    }

    // ═══════════════════════════════════════════════
    // Detail (public)
    // ═══════════════════════════════════════════════
    public function detail($id = null)
    {
        if ($id === null) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(404);
            exit('Product not found.');
        }

        $productModel = new Product();
        $product = $productModel->getPublishedById($id);

        if (!$product) {
            http_response_code(404);
            exit('Product not found.');
        }

        $images = $productModel->getProductImages($id);

        $settingModel = new StoreSetting();
        $settings = $settingModel->all();

        $settingsByKey = [];

        foreach ($settings as $setting) {
            $settingsByKey[$setting['setting_key']] = $setting['setting_value'];
        }

        $this->view('store/product-detail', [
            'product' => $product,
            'images' => $images,
            'settingsByKey' => $settingsByKey
        ]);
    }

    // ═══════════════════════════════════════════════
    // Search AJAX
    // ═══════════════════════════════════════════════
    public function searchAjax()
    {
        $keyword = trim($_GET['q'] ?? '');

        $productModel = new Product();

        if ($keyword === '') {
            $products = $productModel->getAllProducts();
        } else {
            $products = $productModel->searchProductsWithImage($keyword);
        }

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($products, JSON_UNESCAPED_UNICODE);

        exit;
    }
}