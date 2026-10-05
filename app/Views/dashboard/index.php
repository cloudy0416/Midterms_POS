<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Dashboard</h2>

            <p class="text-muted mb-0">
                Welcome back, <?= esc(session()->get('full_name')) ?>!
            </p>
        </div>

        <a
            href="<?= base_url('sales') ?>"
            class="btn btn-primary"
        >
            New Sale
        </a>

    </div>


    <!-- Statistics -->

    <div class="row g-4 mb-4">

        <!-- Products -->

        <div class="col-md-6 col-xl-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Products
                    </h6>

                    <h2 class="mb-3">
                        <?= $productCount ?>
                    </h2>

                    <a
                        href="<?= base_url('products') ?>"
                        class="text-decoration-none"
                    >
                        Manage Products →
                    </a>

                </div>

            </div>

        </div>


        <!-- Customers -->

        <div class="col-md-6 col-xl-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Customers
                    </h6>

                    <h2 class="mb-3">
                        <?= $customerCount ?>
                    </h2>

                    <a
                        href="<?= base_url('customers') ?>"
                        class="text-decoration-none"
                    >
                        Manage Customers →
                    </a>

                </div>

            </div>

        </div>


        <!-- Users -->

        <div class="col-md-6 col-xl-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Users
                    </h6>

                    <h2 class="mb-3">
                        <?= $userCount ?>
                    </h2>

                    <a
                        href="<?= base_url('users') ?>"
                        class="text-decoration-none"
                    >
                        Manage Users →
                    </a>

                </div>

            </div>

        </div>


        <!-- Transactions -->

        <div class="col-md-6 col-xl-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Transactions
                    </h6>

                    <h2 class="mb-3">
                        <?= $saleCount ?>
                    </h2>

                    <a
                        href="<?= base_url('sales/history') ?>"
                        class="text-decoration-none"
                    >
                        View Sales →
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- Sales Summary -->

    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Sales
                    </h6>

                    <h2 class="text-success">
                        ₱<?= number_format($totalSales, 2) ?>
                    </h2>

                    <p class="text-muted mb-0">
                        All recorded transactions
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Today's Sales
                    </h6>

                    <h2 class="text-primary">
                        ₱<?= number_format($todaySales, 2) ?>
                    </h2>

                    <p class="text-muted mb-0">
                        Sales recorded today
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Low Stock + Recent Sales -->

    <div class="row g-4">

        <!-- Low Stock -->

        <div class="col-lg-5">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            Low Stock Products
                        </h5>

                        <a
                            href="<?= base_url('products') ?>"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Products
                        </a>

                    </div>

                </div>


                <div class="card-body p-0">

                    <?php if (!empty($lowStockProducts)): ?>

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead>

                                    <tr>
                                        <th>Product</th>
                                        <th>Stock</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($lowStockProducts as $product): ?>

                                        <tr>

                                            <td>
                                                <?= esc($product['name']) ?>
                                            </td>

                                            <td>

                                                <?php if ($product['stock_quantity'] == 0): ?>

                                                    <span class="badge bg-danger">
                                                        Out of Stock
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge bg-warning text-dark">
                                                        <?= $product['stock_quantity'] ?>
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="p-4 text-center text-muted">

                            No low-stock products.

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <!-- Recent Sales -->

        <div class="col-lg-7">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            Recent Sales
                        </h5>

                        <a
                            href="<?= base_url('sales/history') ?>"
                            class="btn btn-sm btn-outline-primary"
                        >
                            View All
                        </a>

                    </div>

                </div>


                <div class="card-body p-0">

                    <?php if (!empty($recentSales)): ?>

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead>

                                    <tr>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($recentSales as $sale): ?>

                                        <tr>

                                            <td>
                                                <?= esc($sale['product_name']) ?>
                                            </td>

                                            <td>

                                                <?= $sale['customer_name']
                                                    ? esc($sale['customer_name'])
                                                    : 'Walk-in'
                                                ?>

                                            </td>

                                            <td>
                                                <?= $sale['quantity'] ?>
                                            </td>

                                            <td>
                                                ₱<?= number_format(
                                                    $sale['total_price'],
                                                    2
                                                ) ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="p-4 text-center text-muted">

                            No sales recorded yet.

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>