<?php
function getSettingValue(array $settings, string $key): string
{
    return (string) ($settings[$key]['setting_value'] ?? '');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

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
    
    .logo-img {
        width: 36px;
        height: 36px;
        object-fit: contain;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 4px;
        flex-shrink: 0;
    }
    .logo-img-user{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 3px solid yellow;
    }
    .logo-icon {
        font-size: 28px;
    }
    
    .logo h2 {
        font-size: 20px;
        font-weight: 700;
    }
    
    .logo h2 span {
        color: var(--accent-gold);
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
        text-decoration: none;
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
        color: var(--accent-rose) !important;
    }
    
    .menu-item.logout:hover {
        background: rgba(251, 113, 133, 0.2);
        color: #fff !important;
        transform: translateX(4px);
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
        text-decoration: none;
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
    
    .avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--accent-gold), var(--accent-rose));
        color: #3b2969;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        box-shadow: 0 4px 10px rgba(251, 191, 36, 0.4);
    }
    
    /* PAGES */
    .page {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .page.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* ===== SUMMARY GRID ===== */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .summary-card {
        position: relative;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        padding: 22px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 5px solid transparent;
    }
    
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(251, 191, 36, 0.2);
        border-color: rgba(251, 191, 36, 0.4);
    }
    
    .summary-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        z-index: 2;
    }
    
    .summary-info {
        flex: 1;
        z-index: 2;
    }
    
    .summary-label {
        display: block;
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .summary-value {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 6px;
    }
    
    .summary-change {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
    }
    
    .summary-change em {
        font-style: normal;
        opacity: 0.7;
        font-weight: 400;
        font-size: 11px;
        margin-left: 2px;
    }
    
    .summary-change.up      { color: var(--accent-emerald); background: rgba(52, 211, 153, 0.15); }
    .summary-change.down    { color: var(--accent-rose); background: rgba(251, 113, 133, 0.15); }
    .summary-change.neutral { color: var(--accent-gold); background: rgba(251, 191, 36, 0.15); }
    
    .summary-bg-icon {
        position: absolute;
        right: -10px;
        bottom: -20px;
        font-size: 110px;
        opacity: 0.05;
        z-index: 1;
        pointer-events: none;
        transition: transform 0.4s ease;
    }
    
    .summary-card:hover .summary-bg-icon {
        transform: scale(1.15) rotate(-8deg);
        opacity: 0.1;
    }
    
    /* COLOR VARIANTS (Using Gradients/Colors matching the theme) */
    .summary-card.blue { border-left-color: var(--accent-sky); }
    .summary-card.blue .summary-icon { background: rgba(56, 189, 248, 0.15); color: var(--accent-sky); }
    
    .summary-card.green { border-left-color: var(--accent-emerald); }
    .summary-card.green .summary-icon { background: rgba(52, 211, 153, 0.15); color: var(--accent-emerald); }
    
    .summary-card.yellow { border-left-color: var(--accent-gold); }
    .summary-card.yellow .summary-icon { background: rgba(251, 191, 36, 0.15); color: var(--accent-gold); }
    
    .summary-card.red { border-left-color: var(--accent-rose); }
    .summary-card.red .summary-icon { background: rgba(251, 113, 133, 0.15); color: var(--accent-rose); }
    
    .summary-card.purple { border-left-color: #a78bfa; }
    .summary-card.purple .summary-icon { background: rgba(167, 139, 250, 0.15); color: #a78bfa; }
    
    .summary-card.orange { border-left-color: #f59e0b; }
    .summary-card.orange .summary-icon { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    
    /* PAGE HEADER */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .page-header h2 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 4px;
    }
    
    .page-header .subtitle {
        color: var(--text-muted);
        font-size: 14px;
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
    
    /* BADGES */
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge.success { background: rgba(52, 211, 153, 0.15); color: var(--accent-emerald); }
    .badge.pending { background: rgba(251, 191, 36, 0.15); color: var(--accent-gold); }
    
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
    
    .btn-edit, .btn-delete {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: 0.2s;
    }
    
    .btn-edit { background: rgba(56, 189, 248, 0.15); color: var(--accent-sky); border: 1px solid rgba(56, 189, 248, 0.3); }
    .btn-edit:hover { background: rgba(56, 189, 248, 0.3); }
    
    .btn-delete { background: rgba(251, 113, 133, 0.15); color: var(--accent-rose); border: 1px solid rgba(251, 113, 133, 0.3); }
    .btn-delete:hover { background: rgba(251, 113, 133, 0.3); }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { width: 70px; }
        .logo h2, .menu-item span:not(.icon), .sidebar-footer { display: none; }
        .menu-item { justify-content: center; }
        .main-content { padding: 15px; }
        .summary-grid { grid-template-columns: 1fr; }
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
                <span class="logo-icon">⚡</span>
            <?php endif; ?>
            
            <h2>
                <?= e($shopName ?: 'Electro') ?><span>Admin</span>
            </h2>
        </div>

        <nav class="menu">
            <a href="#" class="menu-item active" data-page="dashboard">
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
        
            <a href="/dashboard_shopping/products" class="menu-item" data-page="products">
                <span class="icon">📦</span> Product
            </a>
        
            <a href="/dashboard_shopping/categories" class="menu-item" data-page="categories">
                <span class="icon">🗂️</span> Categories
            </a>
        
            <a href="/dashboard_shopping/store_setting" class="menu-item" data-page="settings">
                <span class="icon">⚙️</span> Store Settings
            </a>
            <a href="#" class="menu-item" data-page="my Account">
                <span class="icon"><i class="fa-solid fa-user"></i></span> My Account
            </a>
            
            <a href="#" class="menu-item" data-page="website">
                <span class="icon"><i class="fa-solid fa-globe"></i></span> View Website
            </a>
        
            <!-- Logout Link -->
            <a href="<?= BASE_URL ?>/logout" 
               class="menu-item logout"
               onclick="return confirm('តើអ្នកប្រាកដជាចង់ចាកចេញមែនទេ?')">
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
                <!-- 
                <div class="avatar">A</div>
                <span>Admin</span> -->
                <span class="notif">🔔</span>
                <?php
                $shopName = getSettingValue($settingsByKey, 'shop_name');
                $shopLogo = getSettingValue($settingsByKey, 'shop_logo');
                ?>
                
                <?php if (!empty($shopLogo)): ?>
                    <img src="<?= e($shopLogo) ?>" alt="<?= e($shopName) ?>" class="logo-img-user">
                <?php else: ?>
                    <span class="logo-icon">⚡</span>
                <?php endif; ?>
                
                <h2>
                    <?= e($shopName ?: 'Electro') ?><span>Admin</span>
                </h2>
            </div>
        </header>

        <section class="page active" id="dashboard">
            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h2>📊 Dashboard Overview</h2>
                    <p class="subtitle">ទិដ្ឋភាពទូទៅនៃហាងអេឡិចត្រូនិចរបស់អ្នក</p>
                </div>
                <button class="btn-primary">+ Quick Add</button>
            </div>
        
            <!-- SUMMARY CARDS -->
            <div class="summary-grid">
                <!-- 1. TOTAL PRODUCTS -->
                <div class="summary-card blue">
                    <div class="summary-icon">📦</div>
                    <div class="summary-info">
                        <span class="summary-label">Total Products</span>
                        <h3 class="summary-value"><?= number_format($totalProducts) ?></h3>
                    </div>
                    <div class="summary-bg-icon">📦</div>
                </div>
        
                <!-- 2. PUBLISHED PRODUCTS -->
                <div class="summary-card green">
                    <div class="summary-icon">✅</div>
                    <div class="summary-info">
                        <span class="summary-label">Published Products</span>
                        <h3 class="summary-value"><?= number_format($publishedProducts) ?></h3>
                        <span class="summary-change up">↑ 8% <em>ពីខែមុន</em></span>
                    </div>
                    <div class="summary-bg-icon">✅</div>
                </div>
        
                <!-- 3. DRAFT PRODUCTS -->
                <div class="summary-card yellow">
                    <div class="summary-icon">📝</div>
                    <div class="summary-info">
                        <span class="summary-label">Draft Products</span>
                        <h3 class="summary-value"><?= number_format($draftProducts) ?></h3>
                        <span class="summary-change neutral">→ 0% <em>មិនផ្លាស់ប្តូរ</em></span>
                    </div>
                    <div class="summary-bg-icon">📝</div>
                </div>
        
                <!-- 4. OUT OF STOCK -->
                <div class="summary-card red">
                    <div class="summary-icon">⚠️</div>
                    <div class="summary-info">
                        <span class="summary-label">Out of Stock</span>
                        <h3 class="summary-value"><?= number_format($outOfStock) ?></h3>
                        <span class="summary-change down">↑ 5 <em>ត្រូវបំពេញ</em></span>
                    </div>
                    <div class="summary-bg-icon">⚠️</div>
                </div>
        
                <!-- 5. TOTAL CATEGORIES -->
                <div class="summary-card purple">
                    <div class="summary-icon">🗂️</div>
                    <div class="summary-info">
                        <span class="summary-label">Total Categories</span>
                        <h3 class="summary-value"><?= number_format($totalCategories) ?></h3>
                        <span class="summary-change up">+2 <em>ថ្មីៗ</em></span>
                    </div>
                    <div class="summary-bg-icon">🗂️</div>
                </div>
        
                <!-- 6. ACTIVE PROMOTIONS -->
                <div class="summary-card orange">
                    <div class="summary-icon">🎁</div>
                    <div class="summary-info">
                        <span class="summary-label">Active Promotions</span>
                        <h3 class="summary-value"><?= number_format($activePromotions) ?></h3>
                        <span class="summary-change up">↑ 3 <em>កំពុងដំណើរការ</em></span>
                    </div>
                    <div class="summary-bg-icon">🎁</div>
                </div>
            </div>
        </section>

        <!-- PRODUCT TABLE -->
        <div class="table-section">
             <div class="page-header" style="margin-bottom: 15px;">
                 <h2>Product List</h2>
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
                     </tr>
                 </thead>
         
                 <tbody>
                     <?php if (count($products) > 0): ?>
                         <?php foreach ($products as $product): ?>
                             <tr>
                                 <td>
                                     <?php if (!empty($product['image_path'])): ?>
                                         <img
                                             src="<?= BASE_URL ?>/<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                             alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                             width="55"
                                             height="55"
                                             style="object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);"
                                        >
                                     <?php else: ?>
                                         <div style="width:55px; height:55px; background:rgba(255,255,255,0.05); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:22px;">
                                             📦
                                         </div>
                                     <?php endif; ?>
                                 </td>
         
                                 <td style="font-weight: 600;">
                                     <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                 </td>
         
                                 <td>
                                     <?= htmlspecialchars($product['brand'], ENT_QUOTES, 'UTF-8') ?>
                                 </td>
         
                                 <td style="color: var(--accent-gold); font-weight: 700;">
                                     $<?= number_format((float)$product['price'], 2) ?>
                                 </td>
         
                                 <td>
                                     <?php if($product['stock_status'] == 'Available'): ?>
                                        <span class="badge success">Available</span>
                                     <?php else: ?>
                                        <span class="badge pending"><?= htmlspecialchars($product['stock_status']) ?></span>
                                     <?php endif; ?>
                                 </td>
         
                                 <td>
                                     <?= htmlspecialchars($product['publish_status'], ENT_QUOTES, 'UTF-8') ?>
                                 </td>
                             </tr>
                         <?php endforeach; ?>
                     <?php else: ?>
                         <tr>
                             <td colspan="6" style="text-align: center; color: #94a3b8;">No products found.</td>
                         </tr>
                     <?php endif; ?>
                 </tbody>
             </table>
        </div>
    </main>
</div>

<script>
    // ===== DROPDOWN TOGGLE =====
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const menuGroup = document.querySelector('.menu-group');
    
    dropdownToggle.addEventListener('click', (e) => {
        e.preventDefault();
        menuGroup.classList.toggle('open');
    });
</script>
</body>
</html>