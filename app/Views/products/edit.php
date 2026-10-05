<?= view('layouts/header') ?>
<?= view('layouts/sidebar') ?>

<div class="content-area">

    <?= view('layouts/topbar') ?>

    <div class="page-header">
        <div>
            <h1>Edit Product</h1>
            <p>Update your product information and inventory.</p>
        </div>

        <a href="<?= base_url('products') ?>" class="btn btn-secondary">
            ← Back to Products
        </a>
    </div>

    <div class="form-card">

        <?php if (isset($validation)): ?>
            <div class="alert alert-error">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <form
            action="<?= base_url('products/update/' . $product['id']) ?>"
            method="POST"
            enctype="multipart/form-data"
        >

            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Product Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= old('name', $product['name']) ?>"
                    placeholder="Enter product name"
                    required
                >
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="price">Price</label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="<?= old('price', $product['price']) ?>"
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity</label>

                    <input
                        type="number"
                        id="stock_quantity"
                        name="stock_quantity"
                        value="<?= old('stock_quantity', $product['stock_quantity']) ?>"
                        placeholder="0"
                        min="0"
                        required
                    >
                </div>

            </div>

            <div class="form-group">

                <label>Current Product Image</label>

                <?php if (!empty($product['image'])): ?>

                    <div class="current-image">
                        <img
                            src="<?= base_url('uploads/products/' . $product['image']) ?>"
                            alt="<?= esc($product['name']) ?>"
                            class="edit-product-image"
                        >
                    </div>

                <?php else: ?>

                    <p class="no-image">
                        No product image available.
                    </p>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="image">Replace Product Image</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png"
                >

                <small class="form-help">
                    Leave empty to keep the current image.
                    JPG or PNG only. Maximum file size: 2 MB.
                </small>

            </div>

            <div class="form-actions">

                <a href="<?= base_url('products') ?>" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

<?= view('layouts/footer') ?>