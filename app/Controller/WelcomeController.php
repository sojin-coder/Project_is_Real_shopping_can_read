<?php

class WelcomeController extends Controller {

    public function __construct() {
        $this->requireLogin();
    }

    public function index() {
        $pdo = Database::connection();

        // ⭐ JOIN ជាមួយ product_images ដើម្បីទាញ image_path
        $products = $pdo->query("
            SELECT 
                p.*,
                pi.image_path
            FROM products AS p
            LEFT JOIN product_images AS pi 
                ON p.id = pi.product_id 
                AND pi.is_primary = 1
            ORDER BY p.id DESC
            LIMIT 8
        ")->fetchAll();

        // ⭐ Statistics
        try {
            $totalProducts     = Database::query("SELECT COUNT(*) FROM products")->fetchColumn();
            $publishedProducts = Database::query("SELECT COUNT(*) FROM products WHERE publish_status = 'Published'")->fetchColumn();
            $draftProducts     = Database::query("SELECT COUNT(*) FROM products WHERE publish_status = 'Draft'")->fetchColumn();
            $outOfStock        = Database::query("SELECT COUNT(*) FROM products WHERE stock_status = 'Out of Stock'")->fetchColumn();
        } catch (Exception $e) {
            $totalProducts = $publishedProducts = $draftProducts = $outOfStock = 0;
        }

        try {
            $totalCategories = Database::query("SELECT COUNT(*) FROM categories")->fetchColumn();
        } catch (Exception $e) {
            $totalCategories = 0;
        }

        try {
            $activePromotions = Database::query("
                SELECT COUNT(*) FROM promotions
                WHERE start_date <= CURDATE() AND end_date >= CURDATE()
            ")->fetchColumn();
        } catch (Exception $e) {
            $activePromotions = 0;
        }

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

        $this->view('welcome', [
            'products'          => $products,
            'totalProducts'     => $totalProducts,
            'publishedProducts' => $publishedProducts,
            'draftProducts'     => $draftProducts,
            'outOfStock'        => $outOfStock,
            'totalCategories'   => $totalCategories,
            'activePromotions'  => $activePromotions,
            'settingsByKey'     => $settingsByKey,   // ← បន្ថែម
        ]);
    }
}