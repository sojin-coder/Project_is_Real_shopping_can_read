<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f6f9;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 640px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-bottom: 20px;
            color: #1a252f;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #3b82f6;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #475569;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 500px) {
            .row {
                grid-template-columns: 1fr;
            }
        }

        .current-image {
            margin-bottom: 10px;
        }

        .current-image img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            margin-top: 10px;
        }

        button:hover {
            background: #2563eb;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 16px;
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Product</h1>

    <a href="<?= BASE_URL ?>/products" class="back">
        ← Back to Products
    </a>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error-box">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form
        action="<?= BASE_URL ?>/products/update/<?= (int) $product['id'] ?>"
        method="POST"
        enctype="multipart/form-data"
    >

        <!-- Product ID (hidden) -->
        <input
            type="hidden"
            name="id"
            value="<?= (int) $product['id'] ?>"
        >

        <!-- Name -->
        <div class="form-group">
            <label>Name <span style="color:#ef4444">*</span></label>
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                required
            >
        </div>

        <!-- Slug -->
        <div class="form-group">
            <label>Slug</label>
            <input
                type="text"
                name="slug"
                value="<?= htmlspecialchars($product['slug'] ?? '') ?>"
                placeholder="Leave empty to auto-generate"
            >
        </div>

        <!-- Category -->
        <div class="form-group">
            <label>Category</label>
            <select name="category_id">
                <option value="">-- No Category --</option>
                <?php foreach (($categories ?? []) as $cat): ?>
                    <option
                        value="<?= (int) $cat['id'] ?>"
                        <?= ((int) ($product['category_id'] ?? 0) === (int) $cat['id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Brand & Model -->
        <div class="row">
            <div class="form-group">
                <label>Brand</label>
                <input
                    type="text"
                    name="brand"
                    value="<?= htmlspecialchars($product['brand'] ?? '') ?>"
                >
            </div>
            <div class="form-group">
                <label>Model</label>
                <input
                    type="text"
                    name="model"
                    value="<?= htmlspecialchars($product['model'] ?? '') ?>"
                >
            </div>
        </div>

        <!-- SKU -->
        <div class="form-group">
            <label>SKU</label>
            <input
                type="text"
                name="sku"
                value="<?= htmlspecialchars($product['sku'] ?? '') ?>"
                placeholder="Leave empty to auto-generate"
            >
        </div>

        <!-- Price -->
        <div class="form-group">
            <label>Price ($) <span style="color:#ef4444">*</span></label>
            <input
                type="number"
                name="price"
                step="0.01"
                min="0"
                value="<?= htmlspecialchars($product['price'] ?? 0) ?>"
                required
            >
        </div>

        <!-- Condition & Stock Status -->
        <div class="row">
            <div class="form-group">
                <label>Condition</label>
                <select name="condition_type">
                    <?php
                    $conditions = ['New', 'Used', 'Refurbished'];
                    $currentCondition = $product['condition_type'] ?? 'New';
                    foreach ($conditions as $c):
                    ?>
                        <option value="<?= $c ?>" <?= $currentCondition === $c ? 'selected' : '' ?>>
                            <?= $c ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
    <label>Stock Status</label>
    <select name="stock_status">
        <?php
                    // កំណត់តម្លៃដែលត្រូវនឹង Database
                    $statuses = ['Available', 'Out of Stock', 'Pre-order'];
                    $cur = $product['stock_status'] ?? 'Available';

                    // បើតម្លៃចាស់មិនត្រូវ បង្ខំឱ្យចាប់ Available
                    if (!in_array($cur, $statuses, true)) {
                        $cur = 'Available';
                    }

                    foreach ($statuses as $s):
                        ?>
                        <option value="<?= $s ?>" <?= $cur === $s ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Publish Status -->
        <div class="form-group">
            <label>Publish Status</label>
            <select name="publish_status">
                <?php
                $publishStatuses = ['Draft', 'Published', 'Archived'];
                $currentPublish = $product['publish_status'] ?? 'Draft';
                foreach ($publishStatuses as $p):
                ?>
                    <option value="<?= $p ?>" <?= $currentPublish === $p ? 'selected' : '' ?>>
                        <?= $p ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Featured -->
        <div class="form-group">
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="is_featured"
                    id="is_featured"
                    value="1"
                    <?= !empty($product['is_featured']) ? 'checked' : '' ?>
                >
                <label for="is_featured" style="margin:0">Featured Product</label>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>

        <!-- Current Images -->
        <div class="form-group">
            <label>Current Images</label>
            <div class="current-image">
                <?php if (!empty($images) && is_array($images)): ?>
                    <?php foreach ($images as $img): ?>
                        <img
                            src="<?= BASE_URL . '/' . htmlspecialchars($img['image_path']) ?>"
                            alt="Product Image"
                        >
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color:#94a3b8;font-size:13px;">No images uploaded yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upload New Image -->
        <div class="form-group">
            <label>Upload New Primary Image</label>
            <input type="file" name="image" id="imageInput" accept="image/*">
            <img id="imagePreview" src="" alt="Preview" style="display:none; width:120px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0; margin-top:10px;">
        </div>

        <button type="submit">Update Product</button>

    </form>

</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block';
            }
        });
    }
</script>

</body>
</html>