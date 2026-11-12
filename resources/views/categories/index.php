<?php require_once dirname(__DIR__, 3) . '/app/Helpers/functions.php'; ?> 

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Electronics Shop</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kantumruy Pro', sans-serif;
    }
    a:hover{
        text-decoration: none;
    }
    a{
        text-decoration: none;
    }
    
    body {
        background: #eef2ff;
    }
    
    .admin-container {
        display: flex;
        min-height: 100vh;
    }
    
    /* SIDEBAR - Blue Background */
    .sidebar {
        width: 260px;
        background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 20px 0;
        box-shadow: 4px 0 20px rgba(30, 58, 138, 0.3);
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
    
    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 25px 25px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }
    
    .logo-icon {
        font-size: 28px;
    }
    
    .logo h2 {
        font-size: 20px;
        font-weight: 700;
    }
    
    .logo h2 span {
        color: #93c5fd;
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
        color: #dbeafe;
        text-decoration: none;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.25s ease;
    }
    
    .menu-item:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateX(4px);
    }
    
    .menu-item.active {
        background: #fff;
        color: #1e40af;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .menu-item.logout {
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,0.15);
        padding-top: 18px;
        color: #fecaca;
    }
    
    .menu-item.logout:hover {
        background: rgba(239, 68, 68, 0.3);
        color: #fff;
    }
    
    .icon {
        font-size: 18px;
    }
    
    .sidebar-footer {
        text-align: center;
        padding: 15px;
        font-size: 12px;
        color: #93c5fd;
    }
    /* Menu Group (រុំ dropdown) */
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
        color: #93c5fd;
    }
    
    .menu-group.open .dropdown-toggle .arrow {
        transform: rotate(180deg);
    }
    
    .menu-group.open .dropdown-toggle {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }
    
    /* Dropdown Menu */
    .dropdown-menu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease, padding 0.3s ease;
        padding-left: 0;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 0 0 10px 10px;
        margin: 0 8px;
    }
    
    .menu-group.open .dropdown-menu {
        max-height: 500px;
        padding: 8px 0;
    }
    
    /* Submenu Items */
    .submenu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px 10px 35px;
        color: #cbd5e1;
        text-decoration: none;
        font-size: 14px;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
    }
    
    .submenu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-left-color: #93c5fd;
        padding-left: 40px;
    }
    
    .submenu-item.active {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border-left-color: #fff;
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
        color: #1e3a8a;
        font-size: 26px;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #1e3a8a;
        font-weight: 600;
    }
    
    .notif {
        font-size: 20px;
        cursor: pointer;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
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
    
    /* STATS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #fff;
        padding: 22px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
        border-left: 5px solid #2563eb;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
    }
    
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    
    .stat-icon.blue { background: #dbeafe; }
    .stat-icon.green { background: #dcfce7; }
    .stat-icon.orange { background: #ffedd5; }
    .stat-icon.purple { background: #ede9fe; }
    
    .stat-card h3 {
         color: #1e3a8a;
         font-size: 22px;
     }
     
     .stat-card p {
         color: #64748b;
         font-size: 13px;
     }
     /* ===== SUMMARY GRID ===== */
      .summary-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
          gap: 20px;
          margin-bottom: 30px;
      }
      
      /* ===== CARD BASE ===== */
      .summary-card {
     position: relative;
     background: #fff;
     padding: 22px;
     border-radius: 16px;
     display: flex;
     align-items: center;
     gap: 18px;
     box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
     overflow: hidden;
     cursor: pointer;
     transition: all 0.3s ease;
     border-left: 5px solid #2563eb;
 }
 
 .summary-card:hover {
     transform: translateY(-5px);
     box-shadow: 0 12px 32px rgba(30, 58, 138, 0.18);
 }
 
 /* ===== ICON BOX ===== */
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
 
 /* ===== TEXT INFO ===== */
 .summary-info {
     flex: 1;
     z-index: 2;
 }
 
 .summary-label {
     display: block;
     font-size: 13px;
     color: #64748b;
     font-weight: 600;
     margin-bottom: 4px;
     text-transform: uppercase;
     letter-spacing: 0.3px;
 }
 
 .summary-value {
     font-size: 28px;
     font-weight: 700;
     color: #1e3a8a;
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
     color: #94a3b8;
     font-weight: 400;
     font-size: 11px;
     margin-left: 2px;
 }
 
 .summary-change.up      { color: #16a34a; background: #dcfce7; }
 .summary-change.down    { color: #dc2626; background: #fee2e2; }
 .summary-change.neutral { color: #d97706; background: #fef3c7; }
 
 /* ===== BACKGROUND GHOST ICON ===== */
 .summary-bg-icon {
     position: absolute;
     right: -10px;
     bottom: -20px;
     font-size: 110px;
     opacity: 0.06;
     z-index: 1;
     pointer-events: none;
     transition: transform 0.4s ease;
 }
 
 .summary-card:hover .summary-bg-icon {
     transform: scale(1.15) rotate(-8deg);
     opacity: 0.1;
 }
 
 /* ===== COLOR VARIANTS ===== */
 .summary-card.blue {
     border-left-color: #2563eb;
 }
 .summary-card.blue .summary-icon {
     background: #dbeafe;
     color: #1e40af;
 }
 
 .summary-card.green {
     border-left-color: #16a34a;
 }
 .summary-card.green .summary-icon {
     background: #dcfce7;
     color: #166534;
 }
 
 .summary-card.yellow {
     border-left-color: #eab308;
 }
 .summary-card.yellow .summary-icon {
     background: #fef9c3;
     color: #854d0e;
 }
 
 .summary-card.red {
     border-left-color: #dc2626;
 }
 .summary-card.red .summary-icon {
     background: #fee2e2;
     color: #991b1b;
 }
 
 .summary-card.purple {
     border-left-color: #9333ea;
 }
 .summary-card.purple .summary-icon {
     background: #f3e8ff;
     color: #6b21a8;
 }
 
 .summary-card.orange {
     border-left-color: #ea580c;
 }
 .summary-card.orange .summary-icon {
     background: #ffedd5;
     color: #9a3412;
 }
 
 /* ===== PAGE HEADER ENHANCEMENT ===== */
 .page-header {
     display: flex;
     justify-content: space-between;
     align-items: center;
     margin-bottom: 25px;
     flex-wrap: wrap;
     gap: 15px;
 }
 
 .page-header h2 {
     color: #1e3a8a;
     font-size: 24px;
     margin-bottom: 4px;
 }
 
 .page-header .subtitle {
     color: #64748b;
     font-size: 14px;
 }
 
 /* ===== RESPONSIVE ===== */
 @media (max-width: 768px) {
     .summary-grid {
         grid-template-columns: 1fr;
     }
 
     .summary-value {
         font-size: 24px;
     }
 
     .summary-icon {
         width: 50px;
         height: 50px;
         min-width: 50px;
         font-size: 24px;
     }
 }
 
 @media (min-width: 769px) and (max-width: 1200px) {
     .summary-grid {
         grid-template-columns: repeat(2, 1fr);
     }
  }
    
    /* TABLE */
    .table-section {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
    }
    
    .table-section h2, .page-header h2 {
        color: #1e3a8a;
        margin-bottom: 18px;
        font-size: 20px;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
    }
    
    th {
        background: #1e40af;
        color: #fff;
        padding: 14px;
        text-align: left;
        font-size: 14px;
    }
    
    td {
        padding: 14px;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
        font-size: 14px;
    }
    
    tr:hover td {
        background: #f8fafc;
    }
    
    /* BADGES */
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge.success { background: #dcfce7; color: #166534; }
    .badge.pending { background: #fef3c7; color: #92400e; }
    
    /* BUTTONS */
    .btn-primary {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.25s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }
    
    .btn-edit, .btn-delete {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }
    
    .btn-edit { background: #dbeafe; color: #1e40af; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
    
    /* CATEGORY GRID */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .category-card {
        background: #fff;
        padding: 30px;
        border-radius: 14px;
        text-align: center;
        font-weight: 600;
        color: #1e3a8a;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
        transition: all 0.25s;
    }
    
    .category-card:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        transform: translateY(-5px);
    }
    
    .category-card span {
        display: block;
        margin-top: 10px;
        font-size: 14px;
        color: #64748b;
    }
    
    .category-card:hover span { color: #bfdbfe; }
    
    /* SETTINGS FORM */
    .settings-form {
        background: #fff;
        padding: 30px;
        border-radius: 14px;
        max-width: 600px;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
    }
    
    .settings-form label {
        display: block;
        margin-bottom: 8px;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 14px;
    }
    
    .settings-form input,
    .settings-form select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border 0.2s;
    }
    
    .settings-form input:focus,
    .settings-form select:focus {
        outline: none;
        border-color: #2563eb;
    }
    
    /* LOGIN */
    .login-box {
        background: #fff;
        max-width: 400px;
        margin: 80px auto;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(30, 58, 138, 0.15);
        text-align: center;
    }
    
    .login-box h2 {
        color: #1e3a8a;
        margin-bottom: 25px;
    }
    
    .login-box input {
        width: 100%;
        padding: 13px;
        margin-bottom: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .login-box input:focus {
        outline: none;
        border-color: #2563eb;
    }
    
    .login-box .btn-primary {
        width: 100%;
        padding: 13px;
        margin-top: 10px;
    }
    
    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { width: 70px; }
        .logo h2, .menu-item span:not(.icon), .sidebar-footer { display: none; }
        .menu-item { justify-content: center; }
        .main-content { padding: 15px; }
    }
</style>
<body>

<div class="admin-container">
    <!-- SIDEBAR --->
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
        
            <a href="/dashboard_shopping/products" class="menu-item " data-page="products">
                <span class="icon">📦</span> Product
            </a>
        
            <a href="dashboard_shopping/categories" class="menu-item active" data-page="categories">
                <span class="icon">🗂️</span> Categories
            </a>
        
            <a href="/dashboard_shopping/store_setting" class="menu-item" data-page="settings">
                <span class="icon">⚙️</span> Store Settings
            </a>
            <a href="#" class="menu-item" data-page="settings">
                <span class="icon"><i class="fa-solid fa-user"></i></span>
                My Account
            </a>
            
            <a href="#" class="menu-item" data-page="website">
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
            <h1 id="pageTitle">Categories</h1>
            <div class="user-info">
                <span class="notif">🔔</span>
                <div class="avatar">A</div>
                <span>Admin</span>
            </div>
        </header>
        
        <div class="table-section">
             <div class="page-header">
                 <h2>Categories List</h2>

                  <a href="<?= BASE_URL ?>/categories/create" class="btn-primary">+ Add categories</a> 
                 
             </div>
         
             
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <?= (int) $category['id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['name'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['slug'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $category['description'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <a href="/categories/edit?id=<?= (int) $category['id'] ?>" class ="btn btn-primary">
                            Edit
                        </a>

                        <form
                            action="/categories/delete"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this category?');"
                        >
                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $category['id'] ?>"
                            >
                            <button type="submit" class ="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No categories found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

        </div>

        
    </main>
</div>

<script >
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

