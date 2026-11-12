<?php
// ដាក់ ២ function នេះនៅខាងលើគេបំផុត ដើម្បីឱ្យវាដំណើរការ
if (!function_exists('getSettingValue')) {
    function getSettingValue(array $settings, string $key): string
    {
        return (string) ($settings[$key]['setting_value'] ?? '');
    }
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
?>

<!-- បង្ហាញ Logo -->
<?php if (!empty($logoUrl)): ?>
        <img src="<?= e($logoUrl) ?>" alt="<?= e($shopName) ?>" class="logo-img">
<?php else: ?>
        <!-- <span class="logo-icon">⚡</span> -->
<?php endif; ?>

<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Electronics Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<style>
    /* ============================================================
       CRIMSON-PURPLE THEME (MATCHING PUBLIC WEB)
       ============================================================ */
    :root {
        --bg-gradient: linear-gradient(180deg, rgba(196, 34, 42, 1) 0%, rgba(59, 41, 105, 1) 75%);
        --glass-bg: rgba(42, 22, 70, 0.65);
        --glass-border: rgba(255, 255, 255, 0.15);
        
        --text-main: #ffffff;
        --text-muted: #d8c9e0;
        
        --accent-gold: #fbbf24;
        --accent-rose: #fb7185;
        --accent-sky: #38bdf8;
        --accent-emerald: #34d399;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kantumruy Pro', sans-serif;
    }

    a {
        text-decoration: none;
    }

    body {
        background: var(--bg-gradient);
        background-attachment: fixed;
        color: var(--text-main);
        min-height: 100vh;
    }

    .admin-container {
        display: flex;
        min-height: 100vh;
    }

    /* SIDEBAR - Glassmorphism */
    .sidebar {
        width: 260px;
        background: rgba(42, 22, 70, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-right: 1px solid var(--glass-border);
        color: var(--text-main);
        display: flex;
        flex-direction: column;
        padding: 20px 0;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 25px 25px;
        border-bottom: 1px solid var(--glass-border);
    }

    .logo-icon {
        font-size: 28px;
    }

    .logo h2 {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }

    .logo h2 span {
        color: var(--accent-gold);
    }

    .logo-img-user {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid var(--accent-gold);
        object-fit: cover;
        box-shadow: 0 0 10px rgba(251, 191, 36, 0.4);
    }

    .logo-img {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid var(--glass-border);
        object-fit: contain;
        background: rgba(255,255,255,0.1);
    }

    .menu {
        flex: 1;
        padding: 20px 15px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        color: var(--text-muted);
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.25s ease;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transform: translateX(4px);
    }

    .menu-item.active {
        background: var(--accent-gold);
        color: #3b2969;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }

    .menu-item.logout {
        margin-top: auto;
        border-top: 1px solid var(--glass-border);
        padding-top: 18px;
        color: var(--accent-rose);
    }

    .menu-item.logout:hover {
        background: rgba(251, 113, 133, 0.2);
        color: #fff;
    }

    .icon {
        font-size: 18px;
    }

    .sidebar-footer {
        text-align: center;
        padding: 15px;
        font-size: 12px;
        color: var(--text-muted);
        opacity: 0.7;
    }

    /* Menu Group (Dropdown) */
    .menu-group {
        display: flex;
        flex-direction: column;
    }

    .dropdown-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .dropdown-toggle .arrow {
        font-size: 10px;
        transition: transform 0.3s ease;
        color: var(--text-muted);
    }

    .menu-group.open .dropdown-toggle .arrow {
        transform: rotate(180deg);
    }

    .menu-group.open .dropdown-toggle {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .dropdown-menu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease, padding 0.3s ease;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0 0 10px 10px;
        margin: 0 8px;
    }

    .menu-group.open .dropdown-menu {
        max-height: 500px;
        padding: 8px 0;
    }

    .submenu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px 10px 35px;
        color: var(--text-muted);
        font-size: 14px;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .submenu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-left-color: var(--accent-gold);
        padding-left: 40px;
    }

    .submenu-item.active {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border-left-color: var(--accent-gold);
        font-weight: 600;
    }

    .submenu-item .icon {
        font-size: 14px;
    }

    /* MAIN CONTENT */
    .main-content {
        flex: 1;
        padding: 25px 35px;
        overflow-y: auto;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .topbar h1 {
        color: #fff;
        font-size: 26px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #fff;
        font-weight: 600;
    }

    .notif {
        font-size: 20px;
        cursor: pointer;
    }

    /* TABLE SECTION */
    .table-section {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        overflow-x: auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h2 {
        color: #fff;
        font-size: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    th {
        background: rgba(0, 0, 0, 0.4);
        color: var(--accent-gold);
        padding: 16px 14px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid var(--glass-border);
    }

    td {
        padding: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
        font-size: 14px;
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.05);
    }

    /* PRODUCT SEARCH */
    .product-search {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 420px;
        height: 46px;
        margin-bottom: 20px;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        transition: all 0.25s ease;
    }

    .product-search .search-icon {
        position: absolute;
        left: 15px;
        color: var(--text-muted);
        font-size: 15px;
        pointer-events: none;
    }

    .product-search input {
        width: 100%;
        height: 100%;
        padding: 0 42px;
        border: none;
        outline: none;
        background: transparent;
        color: #fff;
        font-size: 14px;
    }

    .product-search input::placeholder {
        color: var(--text-muted);
    }

    .product-search:focus-within {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.15);
    }

    .product-search:focus-within .search-icon {
        color: var(--accent-gold);
    }

    .clear-search {
        position: absolute;
        right: 12px;
        display: none;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        color: var(--text-muted);
        cursor: pointer;
    }

    .clear-search:hover {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }

    /* BUTTONS */
    .btn-primary {
        background: var(--accent-gold);
        color: #3b2969;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.25s;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }

    .btn-primary:hover {
        background: #fcd34d;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(251, 191, 36, 0.5);
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary-sm {
        background: var(--accent-sky);
        color: #0c1e2e;
    }
    .btn-primary-sm:hover { background: #7dd3fc; }

    .btn-danger {
        background: rgba(251, 113, 133, 0.15);
        color: var(--accent-rose);
        border: 1px solid rgba(251, 113, 133, 0.3);
    }
    .btn-danger:hover { background: rgba(251, 113, 133, 0.3); }

    .btn-info {
        background: rgba(56, 189, 248, 0.15);
        color: var(--accent-sky);
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .btn-info:hover { background: rgba(56, 189, 248, 0.3); }

    /* BADGES */
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge.success {
        background: rgba(52, 211, 153, 0.15);
        color: var(--accent-emerald);
    }

    .badge.pending {
        background: rgba(251, 191, 36, 0.15);
        color: var(--accent-gold);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
        }

        .logo h2,
        .menu-item span:not(.icon),
        .sidebar-footer {
            display: none;
        }

        .menu-item {
            justify-content: center;
        }

        .main-content {
            padding: 15px;
        }
    }
</style>

<body>

    <div class="admin-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo">
            <?php
                $shopName = getSettingValue($settingsByKey, 'shop_name');
                $shopLogo = getSettingValue($settingsByKey, 'shop_logo');
                ?>
            
                <?php if (!empty($shopLogo)): ?>
                    <img src="<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img">
                <?php else: ?>
                    <!-- <span class="logo-icon">⚡</span> -->
                <?php endif; ?>
            
                <h2>
                    <?= e($shopName ?: 'Electro') ?><span>Admin</span>
                </h2>
            </div>

            <nav class="menu">

                <a href="/dashboard_shopping/" class="menu-item " data-page="dashboard">
                    <span class="icon">📊</span> Dashboard
                </a>

                <div class="menu-group">
                    <a href="#" class="menu-item dropdown-toggle">
                        <span class="icon">🌐</span> Website Manager
                        <span class="arrow">▼</span>
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="submenu-item" data-page="homepage">
                            <span class="icon">🏠</span> Homepage Editor
                        </a>
                        <a href="#" class="submenu-item" data-page="banner">
                            <span class="icon">🖼️</span> Banner & Slider
                        </a>
                        <a href="#" class="submenu-item" data-page="about">
                            <span class="icon">📄</span> About Us
                        </a>
                        <a href="#" class="submenu-item" data-page="contact">
                            <span class="icon">📞</span> Contact Info
                        </a>
                        <a href="#" class="submenu-item" data-page="footer">
                            <span class="icon">🦶</span> Footer Settings
                        </a>
                        <a href="#" class="submenu-item" data-page="promotions">
                            <span class="icon">📢</span> Promotions
                        </a>
                        <a href="#" class="submenu-item" data-page="theme">
                            <span class="icon">🎨</span> Theme & Colors
                        </a>
                    </div>
                </div>

                <a href="/dashboard_shopping/products" class="menu-item active" data-page="products">
                    <span class="icon">📦</span> Product
                </a>

                <a href="/dashboard_shopping/categories" class="menu-item" data-page="categories">
                    <span class="icon">🗂️</span> Categories
                </a>

                <a href="/dashboard_shopping/store_setting" class="menu-item" data-page="settings">
                    <span class="icon">⚙️</span> Store Settings
                </a>
                <a href="#" class="menu-item" data-page="settings">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    My Account
                </a>

                <a href="http://localhost/dashboard_shopping/website/home" class="menu-item" data-page="website">
                    <span class="icon"><i class="fa-solid fa-globe"></i></span>
                    View Website
                </a>

                <a href="#" class="menu-item logout" data-page="logout">
                    <span class="icon">🚪</span> Logout
                </a>
            </nav>

            <div class="sidebar-footer">
                <p>v1.0.0 © 2026(13,10)</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="topbar">
                <h1 id="pageTitle">Dashboard</h1>
                 <div class="user-info">
                <span class="notif">🔔</span>
                <?php
                $shopName = getSettingValue($settingsByKey, 'shop_name');
                $shopLogo = getSettingValue($settingsByKey, 'shop_logo');
                ?>
                
                    <!-- ✅ LOGO FIX: បន្ថែម BASE_URL និង Path -->
                    <?php if (!empty($shopLogo)): ?>
                            <?php
                            $logoPath = (strpos($shopLogo, 'http') === 0)
                                ? $shopLogo
                                : BASE_URL . '/assets/uploads/' . $shopLogo;
                            ?>
                            <img src="<?= e($logoPath) ?>" alt="<?= e($shopName) ?>" class="logo-img-user">
                    <?php else: ?>
                            <span class="logo-icon">⚡</span>
                    <?php endif; ?>
                
                    <h2>
                        <?= e($shopName ?: 'Electro') ?><span>Admin</span>
                    </h2>
                </div>
            </header>

            <div class="table-section">
                <div class="product-search">
                    <i class="fas fa-search search-icon"></i>

                    <input type="text" id="searchProduct" placeholder="Search by product name, brand or SKU..."
                        autocomplete="off">

                    <button type="button" id="clearSearch" class="clear-search" title="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="page-header">
                    <h2>Product List</h2>
                    <a href="<?= BASE_URL ?>/products/create" class="btn-primary">+ Add Product</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="productTable">
                        <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($product['image_path'])): ?>
                                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                                            alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" width="55"
                                                            height="55" style="object-fit:cover; border-radius:8px; border: 1px solid rgba(255,255,255,0.1);">
                                                <?php else: ?>
                                                        <div style="width:55px; height:55px; background:rgba(255,255,255,0.05); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:22px;">📦</div>
                                                <?php endif; ?>
                                            </td>

                                            <td style="font-weight: 600;">
                                                <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($product['brand'], ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td style="color: var(--accent-gold); font-weight: 700;">
                                                $<?= number_format((float) $product['price'], 2) ?>
                                            </td>

                                            <td>
                                                <?php if ($product['stock_status'] == 'Available'): ?>
                                                        <span class="badge success">Available</span>
                                                <?php else: ?>
                                                        <span class="badge pending"><?= htmlspecialchars($product['stock_status']) ?></span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($product['publish_status'], ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <a href="<?= BASE_URL ?>/products/edit/<?= (int) $product['id'] ?>"
                                                    class="btn btn-primary-sm">
                                                    Edit
                                                </a>

                                                <form action="<?= BASE_URL ?>/products/destroy/<?= (int) $product['id'] ?>"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Delete this product?');">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>

                                                <a href="<?= BASE_URL ?>/products/show/<?= (int) $product['id'] ?>"
                                                    class="btn btn-info">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; color: #94a3b8;">No products found.</td>
                                </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script>
        const searchInput = document.getElementById('searchProduct');
        const productTable = document.getElementById('productTable');
        const searchUrl = <?= json_encode(BASE_URL . '/products/search-ajax') ?>;

        function escapeHTML(value) {
            return String(value ?? '').replace(/[&<>"']/g, function (char) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char];
            });
        }

        function renderProducts(products) {
            if (products.length === 0) {
                productTable.innerHTML = `<tr><td colspan="7" style="text-align:center; color:#94a3b8;">No products found.</td></tr>`;
                return;
            }

            productTable.innerHTML = products.map(product => {
                const image = product.image_path
                    ? `<img src="<?= BASE_URL ?>/${escapeHTML(product.image_path)}" width="55" height="55" style="object-fit:cover; border-radius:8px; border: 1px solid rgba(255,255,255,0.1);">`
                    : `<div style="width:55px; height:55px; background:rgba(255,255,255,0.05); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:22px;">📦</div>`;

                return `
            <tr>
                <td>${image}</td>
                <td style="font-weight: 600;">${escapeHTML(product.name)}</td>
                <td>${escapeHTML(product.brand)}</td>
                <td style="color: var(--accent-gold); font-weight: 700;">$${Number(product.price).toFixed(2)}</td>
                <td><span class="badge ${product.stock_status == 'Available' ? 'success' : 'pending'}">${escapeHTML(product.stock_status)}</span></td>
                <td>${escapeHTML(product.publish_status)}</td>
                <td>
                    <a href="<?= BASE_URL ?>/products/edit/${Number(product.id)}" class="btn btn-primary-sm">Edit</a>
                    <form action="<?= BASE_URL ?>/products/destroy/${Number(product.id)}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?');">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <a href="<?= BASE_URL ?>/products/show/${Number(product.id)}" class="btn btn-info">Detail</a>
                </td>
            </tr>
        `;
            }).join('');
        }

        searchInput.addEventListener('input', async function () {
            const keyword = this.value.trim();
            try {
                const response = await fetch(`${searchUrl}?q=${encodeURIComponent(keyword)}`);
                if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
                const result = await response.text();
                const products = JSON.parse(result);
                renderProducts(products);
            } catch (error) {
                console.error('Search error:', error);
            }
        });
    </script>

    <script>
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const menuGroup = document.querySelector('.menu-group');

        dropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            menuGroup.classList.toggle('open');
        });
    </script>

</body>
</html>