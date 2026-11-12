<?php

$router->get("/", [WelcomeController::class, 'index']);

//====================
// Product
//====================
$router->get("/products", [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/store', [ProductController::class, 'store']);
$router->get('/products/show/{id}', [ProductController::class, 'show']);
$router->get('/products/edit/{id}', [ProductController::class, 'edit']);
$router->post('/products/update/{id}', [ProductController::class, 'update']);
$router->post('/products/destroy/{id}', [ProductController::class, 'delete']);

//====================
// Categories
//====================
$router->get("/categories", [CategorieController::class, 'index']);
$router->get('/categories/create', [CategorieController::class, 'create']);
$router->post('/categories/store', [CategorieController::class, 'store']);
$router->get('/categories/show/{id}', [CategorieController::class, 'show']);
$router->get('/categories/edit/{id}', [CategorieController::class, 'edit']);
$router->post('/categories/update/{id}', [CategorieController::class, 'update']);
$router->post('/categories/destroy/{id}', [CategorieController::class, 'delete']);

//====================
// Setting
//====================
$router->get('/store_setting', [SettingController::class, 'index']);
$router->post('/store_setting', [SettingController::class, 'store_setting']);
$router->get('/store_setting/edit', [SettingController::class, 'edit']);
$router->post('/store_setting/update', [SettingController::class, 'update']);

// ═══════════════════════════════════════════════
// AUTH ROUTES
// ═══════════════════════════════════════════════
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

// ═══════════════════════════════════════════════
// Public Website
// ═══════════════════════════════════════════════
$router->get("/website/home", [StoreController::class, 'home']);
$router->get("/website/product/{id}", [ProductController::class, 'detail']);
$router->post("/website/cart/add", [ProductController::class, 'addToCart']);

// ═══════════════════════════════════════════════
// Search Website
// ═══════════════════════════════════════════════
$router->get('/products/search-ajax', [ProductController::class, 'searchAjax']);