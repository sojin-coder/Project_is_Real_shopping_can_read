<?php

require_once dirname(__DIR__) . '/Models/Model.php';
require_once dirname(__DIR__) . '/Models/Categories.php';

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    // ═══════════════════════════════════════════════
    // 1. បង្ហាញបញ្ជី Categories
    // ═══════════════════════════════════════════════
    public function index()
{
    $categoryModel = new Categories();
    $categories = $categoryModel->all();

    // Temporary: prevent undefined variable
    $settingsByKey = [];

    $this->view('categories/index', [
        'title'          => 'Categories',
        'active'         => 'categories',
        'categories'     => $categories,
        'settingsByKey'  => $settingsByKey,
    ]);
}

    // ═══════════════════════════════════════════════
    // 2. បង្ហាញ Form បន្ថែម
    // ═══════════════════════════════════════════════
    public function create()
    {
        $this->view('categories/create', [
            'title'  => 'Add Category',
            'active' => 'categories',
        ]);
    }

    // ═══════════════════════════════════════════════
    // 3. រក្សាទុក Category ថ្មី
    // ═══════════════════════════════════════════════
    public function store()
    {
        $name        = trim($_POST['name'] ?? '');
        $slug        = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Validate
        if ($name === '') {
            $_SESSION['error'] = 'សូមបញ្ចូលឈ្មោះប្រភេទ!';
            header('Location: ' . BASE_URL . '/categories/create');
            exit;
        }

        // Auto-generate slug បើទទេ
        if ($slug === '') {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name), '-'));
        }

        // Check ឈ្មោះស្ទួន
        $exists = Database::query("SELECT id FROM categories WHERE name = ?", [$name])->fetch();
        if ($exists) {
            $_SESSION['error'] = 'ឈ្មោះប្រភេទនេះមានរួចហើយ!';
            header('Location: ' . BASE_URL . '/categories/create');
            exit;
        }

        // Insert
        Database::query("
            INSERT INTO categories (name, slug, description)
            VALUES (?, ?, ?)
        ", [$name, $slug, $description]);

        $_SESSION['success'] = 'បន្ថែមប្រភេទបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/categories');
        exit;
    }

    // ═══════════════════════════════════════════════
    // 4. បង្ហាញ Form កែ
    // ═══════════════════════════════════════════════
    public function edit($id = null)
    {
        // ⭐ គាំទ្រទាំង /edit/1 និង /edit?id=1
        if ($id === null) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid category ID.';
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        $categoryModel = new Categories();
        $category = $categoryModel->find($id);

        if (!$category) {
            $_SESSION['error'] = 'រកមិនឃើញប្រភេទនេះ!';
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        $this->view('categories/edit', [
            'title'    => 'Edit Category',
            'active'   => 'categories',
            'category' => $category,
        ]);
    }

    // ═══════════════════════════════════════════════
    // 5. Update Category
    // ═══════════════════════════════════════════════
    public function update($id = null)
    {
        // ⭐ គាំទ្រទាំង /update/1 និង /update?id=1
        if ($id === null) {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid category ID.';
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        $name        = trim($_POST['name'] ?? '');
        $slug        = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Validate
        if ($name === '') {
            $_SESSION['error'] = 'សូមបញ្ចូលឈ្មោះប្រភេទ!';
            header('Location: ' . BASE_URL . '/categories/edit/' . $id);
            exit;
        }

        // Auto-generate slug
        if ($slug === '') {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name), '-'));
        }

        // Check ឈ្មោះស្ទួន (លើកលែង ID ខ្លួនឯង)
        $exists = Database::query("
            SELECT id FROM categories WHERE name = ? AND id != ?
        ", [$name, $id])->fetch();

        if ($exists) {
            $_SESSION['error'] = 'ឈ្មោះប្រភេទនេះមានរួចហើយ!';
            header('Location: ' . BASE_URL . '/categories/edit/' . $id);
            exit;
        }

        // Update
        Database::query("
            UPDATE categories 
            SET name = ?, slug = ?, description = ?
            WHERE id = ?
        ", [$name, $slug, $description, $id]);

        $_SESSION['success'] = 'កែប្រភេទបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/categories');
        exit;
    }

    // ═══════════════════════════════════════════════
    // 6. លុប Category
    // ═══════════════════════════════════════════════
    public function delete($id = null)
    {
        // ⭐ គាំទ្រទាំង /delete/1 និង /delete?id=1
        if ($id === null) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }

        $id = (int) $id;

        if ($id < 1) {
            $_SESSION['error'] = 'Invalid category ID.';
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        // Check បើមាន Products ប្រើប្រភេទនេះ
        $productCount = Database::query("
            SELECT COUNT(*) FROM products WHERE category_id = ?
        ", [$id])->fetchColumn();

        if ($productCount > 0) {
            $_SESSION['error'] = "មិនអាចលុបបានទេ — មានផលិតផល {$productCount} ប្រើប្រភេទនេះ!";
            header('Location: ' . BASE_URL . '/categories');
            exit;
        }

        // លុប
        $categoryModel = new Categories();
        $categoryModel->delete($id);

        $_SESSION['success'] = 'លុបប្រភេទបានជោគជ័យ!';
        header('Location: ' . BASE_URL . '/categories');
        exit;
    }
}