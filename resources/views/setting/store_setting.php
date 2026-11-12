<?php
$settingsByKey = [];

foreach ($setting as $item) {
    $settingsByKey[$item['setting_key']] = $item;
}

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
    <title>Store Settings - Electronics Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<style>
    .logo-img {
        width: 36px;
        height: 36px;
        object-fit: contain;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 4px;
        flex-shrink: 0;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Kantumruy Pro', sans-serif; }
    body { background: #eef2ff; }
    .admin-container { display: flex; min-height: 100vh; }

    /* SIDEBAR */
    .sidebar {
        width: 260px;
        background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 20px 0;
        box-shadow: 4px 0 20px rgba(30, 58, 138, 0.3);
    }
    .logo {
        display: flex; align-items: center; gap: 10px;
        padding: 0 25px 25px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }
    .logo-icon { font-size: 28px; }
    .logo h2 { font-size: 20px; font-weight: 700; }
    .logo h2 span { color: #93c5fd; }
    .menu { flex: 1; padding: 20px 15px; display: flex; flex-direction: column; gap: 6px; }
    .menu-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 18px; color: #dbeafe; text-decoration: none;
        border-radius: 10px; font-size: 15px; transition: all 0.25s ease;
    }
    .menu-item:hover { background: rgba(255,255,255,0.15); color: #fff; transform: translateX(4px); }
    .menu-item.active { background: #fff; color: #1e40af; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .menu-item.logout {
        margin-top: auto; border-top: 1px solid rgba(255,255,255,0.15);
        padding-top: 18px; color: #fecaca;
    }
    .menu-item.logout:hover { background: rgba(239, 68, 68, 0.3); color: #fff; }
    .icon { font-size: 18px; }
    .sidebar-footer { text-align: center; padding: 15px; font-size: 12px; color: #93c5fd; }

    /* MAIN CONTENT */
    .main-content { flex: 1; padding: 25px 35px; overflow-y: auto; }
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .topbar h1 { color: #1e3a8a; font-size: 26px; }
    .user-info { display: flex; align-items: center; gap: 15px; color: #1e3a8a; font-weight: 600; }
    .notif { font-size: 20px; cursor: pointer; }
    .avatar {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-weight: 700;
    }

    /* SETTINGS HEADER */
    .settings-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 25px; flex-wrap: wrap; gap: 15px;
    }
    .settings-header h2 { color: #1e3a8a; font-size: 24px; margin-bottom: 4px; }
    .settings-header .subtitle { color: #64748b; font-size: 14px; }
    .settings-header .subtitle code {
        background: #e0e7ff; color: #3730a3;
        padding: 2px 6px; border-radius: 4px;
        font-size: 13px; font-family: 'Courier New', monospace;
    }

    /* SETTINGS GRID */
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 22px;
    }

    /* SETTING CARD */
    .setting-card {
        background: #fff; border-radius: 14px; padding: 24px;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
        border-left: 5px solid #2563eb;
        transition: all 0.25s ease;
    }
    .setting-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(30, 58, 138, 0.15);
    }
    .setting-card .setting-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: #dbeafe; color: #1e40af;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; margin-bottom: 16px;
    }
    .setting-card .setting-label {
        display: block; font-size: 13px; color: #64748b;
        font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.3px; margin-bottom: 6px;
    }
    .setting-card .setting-key {
        font-size: 11px; color: #94a3b8;
        font-family: 'Courier New', monospace;
        background: #f1f5f9; padding: 2px 8px;
        border-radius: 4px; display: inline-block; margin-bottom: 14px;
    }
    .setting-card .setting-field { margin-bottom: 16px; }
    .setting-card .setting-field input {
        width: 100%; padding: 11px 14px;
        border: 2px solid #e2e8f0; border-radius: 8px;
        font-size: 14px; color: #1e293b;
        background: #f8fafc; font-family: inherit;
    }
    .setting-card .setting-field input[readonly] {
        cursor: not-allowed; color: #64748b;
    }
    .setting-card .setting-meta {
        font-size: 12px; color: #94a3b8;
        display: flex; align-items: center; gap: 6px;
        margin-bottom: 16px; padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
    }
    .setting-card .btn-save {
        width: 100%; padding: 10px 16px;
        border: none; border-radius: 8px;
        background: #dbeafe; color: #1e40af;
        font-weight: 600; font-size: 13px;
        cursor: pointer; transition: all 0.2s;
        display: flex; align-items: center; justify-content: center;
        gap: 6px; font-family: inherit; text-decoration: none;
    }
    .setting-card .btn-save:hover {
        background: #2563eb; color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }

    /* COLOR VARIANTS */
    .setting-card.green { border-left-color: #16a34a; }
    .setting-card.green .setting-icon { background: #dcfce7; color: #166534; }
    .setting-card.green .btn-save { background: #dcfce7; color: #166534; }
    .setting-card.green .btn-save:hover { background: #16a34a; color: #fff; }

    .setting-card.purple { border-left-color: #9333ea; }
    .setting-card.purple .setting-icon { background: #f3e8ff; color: #6b21a8; }
    .setting-card.purple .btn-save { background: #f3e8ff; color: #6b21a8; }
    .setting-card.purple .btn-save:hover { background: #9333ea; color: #fff; }

    .setting-card.orange { border-left-color: #ea580c; }
    .setting-card.orange .setting-icon { background: #ffedd5; color: #9a3412; }
    .setting-card.orange .btn-save { background: #ffedd5; color: #9a3412; }
    .setting-card.orange .btn-save:hover { background: #ea580c; color: #fff; }

    .setting-card.yellow { border-left-color: #eab308; }
    .setting-card.yellow .setting-icon { background: #fef9c3; color: #854d0e; }
    .setting-card.yellow .btn-save { background: #fef9c3; color: #854d0e; }
    .setting-card.yellow .btn-save:hover { background: #eab308; color: #fff; }

    .setting-card.cyan { border-left-color: #0891b2; }
    .setting-card.cyan .setting-icon { background: #cffafe; color: #155e75; }
    .setting-card.cyan .btn-save { background: #cffafe; color: #155e75; }
    .setting-card.cyan .btn-save:hover { background: #0891b2; color: #fff; }

    .setting-card.pink { border-left-color: #db2777; }
    .setting-card.pink .setting-icon { background: #fce7f3; color: #9d174d; }
    .setting-card.pink .btn-save { background: #fce7f3; color: #9d174d; }
    .setting-card.pink .btn-save:hover { background: #db2777; color: #fff; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { width: 70px; }
        .logo h2, .menu-item span:not(.icon), .sidebar-footer { display: none; }
        .menu-item { justify-content: center; }
        .main-content { padding: 15px; }
        .settings-grid { grid-template-columns: 1fr; }
        .settings-header { flex-direction: column; align-items: flex-start; }
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
            <a href="/dashboard_shopping/" class="menu-item">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="/dashboard_shopping/products" class="menu-item">
                <span class="icon">📦</span> Product
            </a>
            <a href="/dashboard_shopping/categories" class="menu-item">
                <span class="icon">🗂️</span> Categories
            </a>
            <a href="/dashboard_shopping/store_setting" class="menu-item active">
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

            <a href="#" class="menu-item logout">
                <span class="icon">🚪</span> Logout
            </a>
        </nav>
        <div class="sidebar-footer">
            <p>v1.0.0 © 2026</p>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <header class="topbar">
            <h1>Store Settings</h1>
            <div class="user-info">
                <span class="notif">🔔</span>
                <div class="avatar">A</div>
                <span>Admin</span>
            </div>
        </header>

        <section class="page active">
            <div class="settings-header">
                <div>
                    <h2>⚙️ Store Settings</h2>
                    <p class="subtitle">Manage your store configuration stored in the <code>settings</code> table</p>
                </div>
            </div>

            <div class="settings-grid">

                <!-- 1. shop_name -->
                <?php $row = $settingsByKey['shop_name'] ?? null; ?>
                <div class="setting-card blue">
                    <div class="setting-icon"><i class="fa-solid fa-store"></i></div>
                    <span class="setting-label">Shop Name</span>
                    <span class="setting-key">shop_name</span>
                    <div class="setting-field">
                        <input type="text" value="<?= e(getSettingValue($settingsByKey, 'shop_name')) ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 2. telegram_link -->
                <?php $row = $settingsByKey['telegram_link'] ?? null; ?>
                <div class="setting-card cyan">
                    <div class="setting-icon"><i class="fa-brands fa-telegram"></i></div>
                    <span class="setting-label">Telegram Link</span>
                    <span class="setting-key">telegram_link</span>
                    <div class="setting-field">
                        <input type="text" value="<?= e(getSettingValue($settingsByKey, 'telegram_link')) ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 3. contact_email -->
                <?php $row = $settingsByKey['contact_email'] ?? null; ?>
                <div class="setting-card orange">
                    <div class="setting-icon"><i class="fa-solid fa-envelope"></i></div>
                    <span class="setting-label">Contact Email</span>
                    <span class="setting-key">contact_email</span>
                    <div class="setting-field">
                        <input type="text" value="<?= e(getSettingValue($settingsByKey, 'contact_email')) ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 4. shop_logo -->
                <?php $row = $settingsByKey['shop_logo'] ?? null; ?>
                <div class="setting-card purple">
                    <div class="setting-icon"><i class="fa-solid fa-image"></i></div>
                    <span class="setting-label">Shop Logo URL</span>
                    <span class="setting-key">shop_logo</span>
                    <div class="setting-field">
                        <input type="text" value="<?= e(getSettingValue($settingsByKey, 'shop_logo')) ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 5. currency -->
                <?php $row = $settingsByKey['currency'] ?? null; ?>
                <div class="setting-card green">
                    <div class="setting-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <span class="setting-label">Currency</span>
                    <span class="setting-key">currency</span>
                    <div class="setting-field">
                        <input type="text" value="<?= e(getSettingValue($settingsByKey, 'currency')) ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 6. show_featured_products -->
                <?php
                $row = $settingsByKey['show_featured_products'] ?? null;
                $featured = getSettingValue($settingsByKey, 'show_featured_products');
                ?>
                <div class="setting-card yellow">
                    <div class="setting-icon"><i class="fa-solid fa-star"></i></div>
                    <span class="setting-label">Show Featured Products</span>
                    <span class="setting-key">show_featured_products</span>
                    <div class="setting-field">
                        <input type="text" value="<?= $featured === '1' ? 'Enabled (1)' : 'Disabled (0)' ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

                <!-- 7. show_new_arrivals -->
                <?php
                $row = $settingsByKey['show_new_arrivals'] ?? null;
                $newArrivals = getSettingValue($settingsByKey, 'show_new_arrivals');
                ?>
                <div class="setting-card pink">
                    <div class="setting-icon"><i class="fa-solid fa-clock"></i></div>
                    <span class="setting-label">Show New Arrivals</span>
                    <span class="setting-key">show_new_arrivals</span>
                    <div class="setting-field">
                        <input type="text" value="<?= $newArrivals === '1' ? 'Enabled (1)' : 'Disabled (0)' ?>" readonly>
                    </div>
                    <div class="setting-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($row['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                    <?php if ($row): ?>
                        <a href="/dashboard_shopping/store_setting/edit?id=<?= (int) $row['id'] ?>" class="btn-save">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </section>
    </main>
</div>

</body>
</html>