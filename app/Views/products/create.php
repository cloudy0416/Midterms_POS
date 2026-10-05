<?= view('layouts/header') ?>
<?= view('layouts/sidebar') ?>

<div class="content-area">

    <?= view('layouts/topbar') ?>

    <div class="page-header">
        <div>
            <h1>Add Product</h1>
            <p>Add a new product to your inventory.</p>
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

        <form action="<?= base_url('products/store') ?>" method="POST" enctype="multipart/form-data">

            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Product Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= old('name') ?>"
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
                        value="<?= old('price') ?>"
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
                        value="<?= old('stock_quantity') ?>"
                        placeholder="0"
                        min="0"
                        required
                    >
                </div>

            </div>

            <div class="form-group">
                <label for="image">Product Image</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png"
                    required
                >

                <small class="form-help">
                    JPG or PNG only. Maximum file size: 2 MB.
                </small>
            </div>

            <div class="form-actions">

                <a href="<?= base_url('products') ?>" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Add Product
                </button>

            </div>

        </form>

    </div>

</div>

<?= view('layouts/footer') ?>