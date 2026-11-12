<?php
    // Escape text before displaying it in HTML
    $e = static function ($value): string {
        return htmlspecialchars(
            (string) ($value ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );
    };
    
    $mainImage = $images[0]['image_path'] ?? null;
    
    // ==========================================
    // ទាញយក Telegram Link ពី Database ដោយផ្ទាល់
    // ==========================================
    $telegramLink = '';
    try {
        // ប្រសិនបើអ្នកមាន Variable $pdo ឬ $db នៅក្នុង File នេះរួចហើយ
        if (isset($pdo)) {
            $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'telegram_link' LIMIT 1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $telegramLink = $result['setting_value'];
            }
        } elseif (isset($settingsByKey['telegram_link'])) {
            $telegramLink = $settingsByKey['telegram_link'];
        }
    } catch (Exception $e) {
        $telegramLink = '';
    }
    
    
?>
<style>
    /* ============================================================
       PRODUCT DETAIL - DARK THEME (Adjusted for Crimson-Purple BG)
       ============================================================ */
       body {
        background: linear-gradient(180deg,rgba(196, 34, 42, 1) 0%, rgba(59, 41, 105, 1) 75%);
       }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #fbbf24;                       /* មាស — លេចធ្លោលើ gradient */
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 25px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .back-link:hover {
        background: rgba(251, 191, 36, 0.15);  /* មាសថ្លា */
        color: #fcd34d;
        transform: translateX(-3px);
    }

    .product-detail {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
        gap: 32px;
        max-width: 920px;
        margin: 40px auto;
        padding: 32px;
        background: #0f172a;                   /* រក្សា dark ដើម */
        border: 1px solid rgba(251, 191, 36, 0.20);  /* border មាសស្រាល */
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        color: #e2e8f0;
        font-family: 'Battambang', 'Inter', sans-serif;
    }

    .product-gallery {
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .image-wrapper {
        position: relative;
        background: #1e293b;
        border-radius: 16px;
        padding: 20px;
        overflow: hidden;
    }

    .featured-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        padding: 6px 14px;
        border-radius: 6px;
        background: #fb7185;                   /* កុលាប — ស៊ីនឹងក្រហម */
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 6px 16px rgba(251, 113, 133, 0.40);
    }

    .main-product-image {
        width: 100%;
        height: 320px;
        object-fit: contain;
        border-radius: 12px;
        background: transparent;
    }

    .product-thumbnails {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .thumbnail-button {
        width: 64px;
        height: 64px;
        padding: 4px;
        border: 2px solid transparent;
        border-radius: 10px;
        background: #1e293b;
        cursor: pointer;
        transition: all .2s ease;
    }

    .thumbnail-button:hover { 
        border-color: #fbbf24;                 /* hover មាស */
    }
    .thumbnail-button img { width: 100%; height: 100%; object-fit: contain; border-radius: 6px; }

    .product-info {
        display: flex;
        flex-direction: column;
        padding-top: 8px;
    }

    .product-info .category {
        font-size: 11px;
        font-weight: 700;
        color: #fbbf24;                        /* មាសជំនួសខៀវ */
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 8px;
    }

    .product-info h1 {
        font-size: 28px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.3;
        margin: 0 0 12px;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
    }

    .price-row {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 24px;
    }

    .price-row .current-price { 
        font-size: 30px; 
        font-weight: 900; 
        color: #fbbf24;                        /* មាស — លេចធ្លោ */
        text-shadow: 0 2px 12px rgba(251, 191, 36, 0.30);
    }

    /* ===== SPECS BOX ===== */
    .product-specifications {
        background: #0b1120;
        border: 1px solid rgba(251, 191, 36, 0.15);  /* border មាសស្រាល */
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .specs-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #e2e8f0;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(251, 191, 36, 0.20);
    }

    .specs-title i { color: #fbbf24; }         /* icon មាស */

    .specs-content {
        font-size: 13px;
        color: #cbd5e1;
        line-height: 1.6;
        margin: 0;
        padding-bottom: 12px;
        border-bottom: 1px dashed rgba(251, 191, 36, 0.25);
    }

    .specs-footer {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #94a3b8;
    }

    .specs-footer span { display: flex; align-items: center; gap: 4px; }
    .specs-footer i.fa-shield { color: #34d399; }       /* បៃតង — ដូចដើម */
    .specs-footer i.fa-circle-check { color: #38bdf8; } /* មេឃ — ស៊ីនឹង gradient */
    .specs-footer strong { color: #34d399; font-weight: 600; }

    /* ===== DESCRIPTION ===== */
    .product-description { margin-bottom: 24px; }
    .product-description p { font-size: 13px; color: #cbd5e1; line-height: 1.6; margin: 0; }

    /* ===== ACTION BUTTONS ===== */
    .product-actions {
        margin-top: auto;
        display: flex;
        flex-direction: column;
    }

    /* Bottom Two Buttons */
    .bottom-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        width: 94%;
    }

    .btn-gmail, .btn-telegram-bottom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        background: transparent;
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #334155;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s ease;
    }

    .btn-gmail:hover {
        background: rgba(251, 113, 133, 0.15);  /* hover កុលាប */
        border-color: #fb7185;
    }

    .btn-telegram-bottom:hover {
        background: rgba(56, 189, 248, 0.15);   /* hover មេឃ */
        border-color: #38bdf8;
    }

    .btn-gmail i { color: #fb7185; }            /* កុលាប */
    .btn-telegram-bottom i { color: #38bdf8; }  /* មេឃ */

    /* ===== NO IMAGE ===== */
    .no-image {
        display: grid;
        place-items: center;
        height: 320px;
        background: #1e293b;
        border-radius: 16px;
        color: #64748b;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .product-detail { grid-template-columns: 1fr; padding: 20px; margin: 16px; gap: 24px; }
        .main-product-image { height: 260px; }
        .product-info h1 { font-size: 22px; }
        .price-row .current-price { font-size: 24px; }
    }
</style>

<a href="<?= BASE_URL ?>/website/home" class="back-link">← Back to List</a>
<section class="product-detail">
    <!-- Left Side: Image -->
    <div class="product-gallery">
        <div class="image-wrapper">
            <?php if ((int) $product['is_featured'] === 1): ?>
                <span class="featured-badge">Hot Deals</span>
            <?php endif; ?>

            <?php if ($mainImage): ?>
                <img id="main-product-image" class="main-product-image" src="<?= BASE_URL . '/' . $e($mainImage) ?>" alt="<?= $e($product['name']) ?>">
            <?php else: ?>
                <div class="no-image">No image available</div>
            <?php endif; ?>
        </div>

        <?php if (count($images) > 1): ?>
            <div class="product-thumbnails">
                <?php foreach ($images as $image): ?>
                    <button type="button" class="thumbnail-button" onclick="changeProductImage(this)" data-image="<?= BASE_URL . '/' . $e($image['image_path']) ?>">
                        <img src="<?= BASE_URL . '/' . $e($image['image_path']) ?>" alt="Product image">
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Side: Information -->
    <div class="product-info">
        <p class="category"><?= $e($product['category_name'] ?? 'SMARTPHONES') ?></p>
        <h1><?= $e($product['name']) ?></h1>

        <div class="price-row">
            <span class="current-price">$<?= number_format((float) $product['price'], 0) ?></span>
        </div>

        <!-- Specs Box -->
        <div class="product-specifications">
            <div class="specs-title">
                <i class="fa-solid fa-sliders"></i> ព័ត៌មានបច្ចេកទេស (Specs):
            </div>
            <p class="specs-content">
                <?= $e($product['brand'] ?? '') ?> <?= $e($product['model'] ?? '') ?> | 
                <?= $e($product['condition_type'] ?? '') ?> | 
                <?= $e($product['stock_status'] ?? '') ?> | 
                SKU: <?= $e($product['sku'] ?? 'N/A') ?>
            </p>
            <div class="specs-footer">
                <span><i class="fa-solid fa-shield"></i> ការធានា: <strong>១ ឆ្នាំ</strong></span>
                <span><i class="fa-solid fa-circle-check"></i> ស្ថានភាព: <strong>មានស្តុក</strong></span>
            </div>
        </div>

        <!-- Description -->
        <div class="product-description">
            <p><?= nl2br($e($product['description'] ?? 'No description available.')) ?></p>
        </div>

        <!-- Actions -->
        <div class="product-actions">
            <!-- Bottom Two Buttons -->
            <div class="bottom-actions">
                <a href="mailto:sales@techhub.com.kh?subject=Inquiry: <?= $e($product['name']) ?>" class="btn-gmail">
                    <i class="fa-solid fa-envelope"></i> Gmail
                </a>
                
                <!-- ប៊ូតុង Telegram (ប្រើ $telegramLink ដែលមាន Link រួចហើយ) -->
                <a href="<?= $telegramLink ?>" target="_blank" class="btn-telegram-bottom">
                    <i class="fa-brands fa-telegram"></i>
                    <span>Telegram</span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function changeProductImage(button) {
    const mainImage = document.getElementById('main-product-image');
    if (mainImage) { mainImage.src = button.dataset.image; }
}
</script>