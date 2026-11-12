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
    <title>Edit Setting - Electronics Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<style>
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
    .menu-item.active { background: #fff; color: #1e40af; font-weight: 600; }
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
    .avatar {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-weight: 700;
    }

    /* FORM */
    .edit-form-wrapper {
        background: #fff; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.08);
        overflow: hidden; max-width: 700px;
    }
    .edit-form-header {
        background: linear-gradient(135deg, #1e40af, #2563eb);
        color: #fff; padding: 25px 30px;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 15px;
    }
    .edit-form-header h2 {
        font-size: 22px; display: flex; align-items: center; gap: 10px;
    }
    .badge-id {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
        border: 1px solid rgba(255,255,255,0.3);
    }
    .edit-form-body { padding: 30px; }

    .form-group {
        margin-bottom: 24px; padding-bottom: 24px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .form-group:last-of-type { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
    .form-group label {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 8px; color: #1e3a8a;
        font-weight: 600; font-size: 14px;
    }
    .form-group .field-hint {
        display: block; font-size: 12px; color: #94a3b8;
        margin-bottom: 8px; font-family: 'Courier New', monospace;
        background: #f1f5f9; padding: 3px 8px;
        border-radius: 4px; width: fit-content;
    }
    .form-group input {
        width: 100%; padding: 12px 16px;
        border: 2px solid #e2e8f0; border-radius: 10px;
        font-size: 14px; color: #1e293b;
        background: #f8fafc; transition: all 0.2s;
        font-family: inherit;
    }
    .form-group input:focus {
        outline: none; border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    .form-group input[readonly] {
        background: #f1f5f9; cursor: not-allowed; color: #64748b;
    }
    .form-meta {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: #94a3b8; margin-top: 8px;
    }

    .form-actions {
        display: flex; gap: 12px;
        padding: 20px 30px 30px; background: #f8fafc;
        border-top: 1px solid #e2e8f0; flex-wrap: wrap;
    }
    .btn {
        padding: 12px 24px; border: none; border-radius: 10px;
        cursor: pointer; font-weight: 600; font-size: 14px;
        transition: all 0.25s; display: inline-flex;
        align-items: center; justify-content: center;
        gap: 8px; font-family: inherit; text-decoration: none;
    }
    .btn-primary {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    }
    .btn-secondary {
        background: #fff; color: #475569;
        border: 2px solid #e2e8f0;
    }
    .btn-secondary:hover {
        background: #f1f5f9; border-color: #cbd5e1; color: #1e293b;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { width: 70px; }
        .logo h2, .menu-item span:not(.icon), .sidebar-footer { display: none; }
        .menu-item { justify-content: center; }
        .main-content { padding: 15px; }
        .edit-form-body { padding: 20px; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; }
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
            <h1>Edit Store Setting</h1>
            <div class="user-info">
                <div class="avatar">A</div>
                <span>Admin</span>
            </div>
        </header>

        <!-- ===== EDIT FORM ===== -->
        <form action="/dashboard_shopping/store_setting/update" method="POST" class="edit-form-wrapper">

            <!-- Hidden inputs ចាំបាច់ -->
            <input type="hidden" name="id" value="<?= (int) ($editItem['id'] ?? 0) ?>">
            <input type="hidden" name="setting_key" value="<?= e($editItem['setting_key'] ?? '') ?>">

            <div class="edit-form-header">
                <h2><i class="fa-solid fa-pen-to-square"></i> Edit Setting</h2>
                <span class="badge-id">ID: #<?= (int) ($editItem['id'] ?? 0) ?></span>
            </div>

            <div class="edit-form-body">

                <!-- Setting Key (readonly) -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-tag" style="color:#2563eb;"></i>
                        Setting Key
                    </label>
                    <span class="field-hint"><?= e($editItem['setting_key'] ?? '') ?></span>
                    <input
                        type="text"
                        value="<?= e($editItem['setting_key'] ?? '') ?>"
                        readonly
                    >
                </div>

                <!-- Setting Value (កែបាន) -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-pen" style="color:#16a34a;"></i>
                        Setting Value <span style="color:#dc2626;">*</span>
                    </label>
                    <input
                        type="text"
                        name="setting_value"
                        value="<?= e($editItem['setting_value'] ?? '') ?>"
                        placeholder="Enter value"
                        required
                        autofocus
                    >
                    <div class="form-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>Updated: <?= e($editItem['updated_at'] ?? 'Not updated yet') ?></span>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
                <a href="/dashboard_shopping/store_setting" class="btn btn-secondary">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>

        </form>

    </main>
</div>

</body>
</html>