<?= $this->include('layouts/header') ?>

<?= $this->include('layouts/sidebar') ?>

<div class="main-content">

    <?= $this->include('layouts/topbar') ?>

    <main class="page-content">

        <div class="page-header">

            <div>
                <h1>Products</h1>
                <p>Manage your products and inventory.</p>
            </div>

            <a href="<?= base_url('products/create') ?>"
               class="btn btn-primary">
                + Add Product
            </a>

        </div>


        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>

        <?php endif; ?>


        <div class="card">

            <div class="card-header">

                <h2>Product List</h2>

            </div>


            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($products)): ?>

                            <?php foreach ($products as $product): ?>

                                <tr>

                                    <td>

                                        <?php if (!empty($product['image'])): ?>

                                            <img
                                                src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                                class="product-image"
                                                alt="<?= esc($product['name']) ?>">

                                        <?php else: ?>

                                            <div class="no-image">
                                                No Image
                                            </div>

                                        <?php endif; ?>

                                    </td>


                                    <td>
                                        <strong>
                                            <?= esc($product['name']) ?>
                                        </strong>
                                    </td>


                                    <td>
                                        ₱<?= number_format($product['price'], 2) ?>
                                    </td>


                                    <td>

                                        <?php if ($product['stock_quantity'] > 0): ?>

                                            <span class="badge badge-success">
                                                <?= esc($product['stock_quantity']) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="badge badge-danger">
                                                Out of Stock
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>
                                        <?= date('M d, Y', strtotime($product['created_at'])) ?>
                                    </td>


                                    <td>

                                        <a href="<?= base_url('products/edit/' . $product['id']) ?>"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="<?= base_url('products/delete/' . $product['id']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6"
                                    style="text-align:center; padding:30px; color:#6b7280;">

                                    No products found.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

<?= $this->include('layouts/footer') ?>