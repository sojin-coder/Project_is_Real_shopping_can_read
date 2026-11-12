<?php

$setting = $setting ?? [];

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
    <title>Admin Dashboard - Electronics Shop</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kantumruy Pro', sans-serif;
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

    /* ═══════════════════════════════════════════════
   PRODUCT FORM
   ═══════════════════════════════════════════════ */
     .product-form {
         background: #fff;
         padding: 35px 40px;
         border-radius: 16px;
         box-shadow: 0 4px 24px rgba(30, 58, 138, 0.08);
         max-width: 820px;
         margin: 0 auto;
     }
     
     /* Form Sections */
     .form-section {
         margin-bottom: 30px;
         padding-bottom: 25px;
         border-bottom: 2px dashed #e2e8f0;
     }
     
     .form-section:last-of-type {
         border-bottom: none;
     }
     
     .section-title {
         color: #1e3a8a;
         font-size: 16px;
         font-weight: 700;
         margin-bottom: 20px;
         display: flex;
         align-items: center;
         gap: 8px;
     }
     
     /* Row Layout */
     .form-row {
         display: grid;
         grid-template-columns: 1fr 1fr;
         gap: 20px;
         margin-bottom: 18px;
     }
     
     .form-group {
         margin-bottom: 18px;
     }
     
     .form-row .form-group {
         margin-bottom: 0;
     }
     
     /* Labels */
     .form-group label {
         display: block;
         margin-bottom: 8px;
         color: #1e3a8a;
         font-weight: 600;
         font-size: 14px;
     }
     
     .form-group label em {
         color: #94a3b8;
         font-size: 12px;
         font-weight: 400;
         font-style: normal;
     }
     
     .required {
         color: #dc2626;
         font-weight: 700;
     }
     
     /* Inputs */
     .form-group input[type="text"],
     .form-group input[type="number"],
     .form-group select,
     .form-group textarea {
         width: 100%;
         padding: 13px 16px;
         border: 2px solid #e2e8f0;
         border-radius: 10px;
         font-size: 14px;
         font-family: 'Kantumruy Pro', sans-serif;
         color: #334155;
         background: #f8fafc;
         transition: all 0.25s ease;
     }
     
     .form-group input:focus,
     .form-group select:focus,
     .form-group textarea:focus {
         outline: none;
         border-color: #2563eb;
         background: #fff;
         box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
     }
     
     .form-group input[readonly] {
         background: #f1f5f9;
         color: #64748b;
         cursor: not-allowed;
     }
     
     .form-group textarea {
         resize: vertical;
         min-height: 120px;
         line-height: 1.6;
     }
     
     /* ═══════════════════════════════════════════════
        CHECKBOX
        ═══════════════════════════════════════════════ */
     .checkbox-group {
         margin-top: 10px;
     }
     
     .checkbox-label {
         display: inline-flex !important;
         align-items: center;
         gap: 10px;
         padding: 12px 20px;
         background: #eff6ff;
         border: 2px solid #bfdbfe;
         border-radius: 10px;
         cursor: pointer;
         transition: all 0.2s;
         font-weight: 600 !important;
         color: #1e40af !important;
     }
     
     .checkbox-label:hover {
         background: #dbeafe;
         border-color: #2563eb;
     }
     
     .checkbox-label input[type="checkbox"] {
         width: 18px;
         height: 18px;
         accent-color: #2563eb;
         cursor: pointer;
     }
     
     /* ═══════════════════════════════════════════════
        IMAGE UPLOAD
        ═══════════════════════════════════════════════ */
     .image-upload-box {
         border: 2px dashed #cbd5e1;
         border-radius: 12px;
         padding: 25px;
         text-align: center;
         background: #f8fafc;
         transition: all 0.25s ease;
     }
     
     .image-upload-box:hover {
         border-color: #2563eb;
         background: #eff6ff;
     }
     
     .image-upload-box input[type="file"] {
         width: 100%;
         padding: 10px;
         border: 2px solid #e2e8f0;
         border-radius: 10px;
         font-size: 13px;
         background: #fff;
         cursor: pointer;
     }
     
     .image-upload-box input[type="file"]::file-selector-button {
         background: linear-gradient(135deg, #2563eb, #1e40af);
         color: #fff;
         border: none;
         padding: 8px 16px;
         border-radius: 8px;
         font-weight: 600;
         font-size: 13px;
         cursor: pointer;
         margin-right: 12px;
     }
     
     #preview-container {
         margin-top: 15px;
         padding: 15px;
         background: #f1f5f9;
         border-radius: 12px;
         text-align: center;
     }
     
     #preview {
         width: 180px;
         height: 180px;
         object-fit: cover;
         border-radius: 12px;
         border: 3px solid #2563eb;
         box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
     }
     
     /* ═══════════════════════════════════════════════
        FORM ACTIONS
        ═══════════════════════════════════════════════ */
     .form-actions {
         display: flex;
         gap: 15px;
         margin-top: 30px;
         padding-top: 25px;
         border-top: 2px solid #e2e8f0;
     }
     
     .btn-save {
         flex: 1;
         padding: 15px;
         background: linear-gradient(135deg, #2563eb, #1e40af);
         color: #fff;
         border: none;
         border-radius: 10px;
         font-size: 16px;
         font-weight: 700;
         font-family: 'Kantumruy Pro', sans-serif;
         cursor: pointer;
         transition: all 0.3s;
         box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
     }
     
     .btn-save:hover {
         transform: translateY(-3px);
         box-shadow: 0 10px 28px rgba(37, 99, 235, 0.45);
     }
     
     .btn-cancel {
         padding: 15px 30px;
         background: #f1f5f9;
         color: #64748b;
         border: 2px solid #e2e8f0;
         border-radius: 10px;
         font-size: 15px;
         font-weight: 600;
         text-decoration: none;
         transition: all 0.25s;
         display: flex;
         align-items: center;
     }
     
     .btn-cancel:hover {
         background: #fee2e2;
         border-color: #fecaca;
         color: #991b1b;
     }
     
     /* ═══════════════════════════════════════════════
        RESPONSIVE
        ═══════════════════════════════════════════════ */
     @media (max-width: 640px) {
         .product-form {
             padding: 25px 20px;
         }
     
         .form-row {
             grid-template-columns: 1fr;
         }
     
         .form-actions {
             flex-direction: column;
         }
     
         .btn-cancel {
             justify-content: center;
         }
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
       /* ═══════════════════════════════════════════════
       PRODUCT FORM CONTAINER
       ═══════════════════════════════════════════════ */
    .product-form-container {
        background: #fff;
        padding: 35px 40px;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(30, 58, 138, 0.08);
        max-width: 720px;
        margin: 0 auto;
        animation: fadeIn 0.4s ease;
    }
    
    .product-form-container h1 {
        color: #1e3a8a;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .product-form-container h1::before {
        content: "📦";
        font-size: 28px;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #2563eb;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 25px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .back-link:hover {
        background: #dbeafe;
        color: #1e40af;
        transform: translateX(-3px);
    }
    
    /* ═══════════════════════════════════════════════
       FORM FIELDS
       ═══════════════════════════════════════════════ */
    .product-form-container form > div {
        margin-bottom: 22px;
    }
    
    .product-form-container label {
        display: block;
        margin-bottom: 8px;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.2px;
    }
    
    .product-form-container label::after {
        content: " *";
        color: #dc2626;
        font-weight: 700;
    }
    
    /* Remove required star for optional fields */
    .product-form-container div:nth-child(2) label::after,
    .product-form-container div:nth-child(3) label::after,
    .product-form-container div:nth-child(6) label::after {
        content: "";
    }
    
    .product-form-container input[type="text"],
    .product-form-container input[type="number"],
    .product-form-container textarea {
        width: 100%;
        padding: 13px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Kantumruy Pro', sans-serif;
        color: #334155;
        background: #f8fafc;
        transition: all 0.25s ease;
    }
    
    .product-form-container input[type="text"]:focus,
    .product-form-container input[type="number"]:focus,
    .product-form-container textarea:focus {
        outline: none;
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    
    .product-form-container input::placeholder,
    .product-form-container textarea::placeholder {
        color: #94a3b8;
        font-size: 13px;
    }
    
    .product-form-container textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }
    
    /* ═══════════════════════════════════════════════
       FILE INPUT (IMAGE UPLOAD)
       ═══════════════════════════════════════════════ */
    .image-upload-box {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.25s ease;
        cursor: pointer;
    }
    
    .image-upload-box:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }
    
    .image-upload-box::before {
        content: "📷 ចុចដើម្បីជ្រើសរើសរូបភាព";
        display: block;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .product-form-container input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .product-form-container input[type="file"]:hover {
        border-color: #2563eb;
    }
    
    .product-form-container input[type="file"]::file-selector-button {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        margin-right: 12px;
        transition: all 0.2s;
    }
    
    .product-form-container input[type="file"]::file-selector-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    
    /* ═══════════════════════════════════════════════
       IMAGE PREVIEW
       ═══════════════════════════════════════════════ */
    #preview-container {
        margin-top: 15px !important;
        padding: 15px;
        background: #f1f5f9;
        border-radius: 12px;
        text-align: center;
        border: 2px solid #e2e8f0;
    }
    
    #preview {
        width: 180px !important;
        height: 180px !important;
        object-fit: cover;
        border-radius: 12px !important;
        border: 3px solid #2563eb !important;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
        transition: transform 0.3s ease;
    }
    
    #preview:hover {
        transform: scale(1.05);
    }
    
    /* ═══════════════════════════════════════════════
       SUBMIT BUTTON
       ═══════════════════════════════════════════════ */
    .product-form-container button[type="submit"] {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        font-family: 'Kantumruy Pro', sans-serif;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .product-form-container button[type="submit"]::before {
        content: "💾";
        font-size: 18px;
    }
    
    .product-form-container button[type="submit"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(37, 99, 235, 0.45);
    }
    
    .product-form-container button[type="submit"]:active {
        transform: translateY(-1px);
    }
    
    /* ═══════════════════════════════════════════════
       TWO-COLUMN LAYOUT (Price + Stock)
       ═══════════════════════════════════════════════ */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    /* ═══════════════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════════════ */
    @media (max-width: 640px) {
        .product-form-container {
            padding: 25px 20px;
        }
    
        .form-row {
            grid-template-columns: 1fr;
        }
    
        .product-form-container h1 {
            font-size: 20px;
        }
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
            <h1 id="pageTitle">Dashboard</h1>
            <div class="user-info">
                <span class="notif">🔔</span>
                <div class="avatar">A</div>
                <span>Admin</span>
            </div>
        </header>
        
        <div class="product-form-container">
        <h1>Add New Product</h1>
        <a href="<?= BASE_URL ?>/products" class="back-link">← Back to List</a>
<form action="<?= BASE_URL ?>/products/store" method="POST" enctype="multipart/form-data" class="product-form">

    <!-- ═══════════════════════════════════════════════ -->
    <!-- SECTION 1: BASIC INFORMATION -->
    <!-- ═══════════════════════════════════════════════ -->
    <div class="form-section">
        <h3 class="section-title">📋 ព័ត៌មានមូលដ្ឋាន</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Product Name <span class="required">*</span></label>
                <input type="text" name="name" placeholder="iPhone 15 Pro" required>
            </div>
            <div class="form-group">
                <label>Category <span class="required">*</span></label>
                <select name="category_id" required>
                    <option value="">-- ជ្រើសរើសប្រភេទ --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" placeholder="Apple, Samsung...">
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" name="model" placeholder="A2848">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" placeholder="IP15PRO-256-BLK">
            </div>
            <div class="form-group">
                <label>Slug <em>(auto)</em></label>
                <input type="text" name="slug" readonly>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- SECTION 2: PRICING & STATUS -->
    <!-- ═══════════════════════════════════════════════ -->
    <div class="form-section">
        <h3 class="section-title">💰 តម្លៃ និងស្ថានភាព</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Price ($) <span class="required">*</span></label>
                <input type="number" name="price" step="0.01" min="0" placeholder="0.00" required>
            </div>

            <!-- ⭐ CONDITION — ត្រូវតែ: 'New', 'Used', 'Refurbished' -->
            <div class="form-group">
                <label>Condition</label>
                <select name="condition_type">
                    <option value="New" selected>✨ New</option>
                    <option value="Used">♻️ Used</option>
                    <option value="Refurbished">🔧 Refurbished</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <!-- ⭐ STOCK — ត្រូវតែ: 'Available', 'Out of Stock' -->
            <div class="form-group">
                <label>Stock Status</label>
                <select name="stock_status">
                    <option value="Available" selected>✅ Available</option>
                    <option value="Out of Stock">❌ Out of Stock</option>
                </select>
            </div>

            <!-- ⭐ PUBLISH — ត្រូវតែ: 'Draft', 'Published' -->
            <div class="form-group">
                <label>Publish Status</label>
                <select name="publish_status">
                    <option value="Draft" selected>📝 Draft</option>
                    <option value="Published">🌐 Published</option>
                </select>
            </div>
        </div>

        <div class="form-group checkbox-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_featured" value="1">
                <span>⭐ បង្ហាញជា Featured Product</span>
            </label>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- SECTION 3: IMAGE -->
    <!-- ═══════════════════════════════════════════════ -->
    <div class="form-section">
        <h3 class="section-title">🖼️ រូបភាពផលិតផល</h3>
        <div class="form-group">
            <div class="image-upload-box">
                <input type="file" name="image" id="image" accept="image/*">
                <div id="preview-container" style="display: none;">
                    <img id="preview" src="" alt="Preview">
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- SECTION 4: DESCRIPTION -->
    <!-- ═══════════════════════════════════════════════ -->
    <div class="form-section">
        <h3 class="section-title">📝 ការពិពណ៌នា</h3>
        <div class="form-group">
            <textarea name="description" rows="5" placeholder="សរសេរការពិពណ៌នា..."></textarea>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════ -->
    <!-- SUBMIT -->
    <!-- ═══════════════════════════════════════════════ -->
    <div class="form-actions">
        <button type="submit" class="btn-save">💾 Save Product</button>
        <a href="<?= BASE_URL ?>/products" class="btn-cancel">✖ Cancel</a>
    </div>

</form>
    </div>
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
     const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('preview-container');

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
        } else {
            preview.src = '';
            previewContainer.style.display = 'none';
        }
    });
    

</script>
</body>
</html>
