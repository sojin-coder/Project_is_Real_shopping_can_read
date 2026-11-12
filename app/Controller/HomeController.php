<?php

class HomeController extends Controller
{
    public function index()
{
    $productModel = new Product();
    $products = $productModel->all();

    $settingModel = new Setting();
    $setting = $settingModel->all();

    $settingsByKey = [];

    foreach ($setting as $item) {
        $settingsByKey[$item['setting_key']] = $item['setting_value'];
    }

    $this->view('public/home', [
        'title' => 'Home',
        'products' => $products,
        'settingsByKey' => $settingsByKey
    ]);
    
}
public function home()
    {
        $settingModel = new StoreSetting();
        $setting = $settingModel->all();

        $settingsByKey = [];

        foreach ($setting as $item) {
            $settingsByKey[$item['setting_key']] =
                $item['setting_value'];
        }

        $this->view('store/homepage', [
            'settingsByKey' => $settingsByKey
        ]);
    }
}