<?php

require_once __DIR__ . '/../Models/StoreSetting.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Categories.php';   // ✅ បន្ថែម

class StoreController extends Controller
{
    public function home()
    {
        // Get store settings
        $settingModel = new StoreSetting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] =
                $item['setting_value'];
        }

        // Get products and their primary images
        $productModel = new Product();
        $products = $productModel->getAllProducts();

        // ✅ ទាញ Categories ពី Database
        $categoryModel = new Categories();
        $categories = $categoryModel->all();

        // Send data to homepage
        $this->view('store/homepage', [
            'settingsByKey' => $settingsByKey,
            'products' => $products,
            'categories' => $categories,   // ✅ បន្ថែម
        ]);
    }

    public function detail($id)
    {
        $productModel = new Product();

        $product = $productModel->getPublishedById((int) $id);

        if (!$product) {
            http_response_code(404);
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $images = $productModel->getProductImages((int) $id);

        require_once __DIR__ . '/../Views/website/product-detail.php';
    }
}