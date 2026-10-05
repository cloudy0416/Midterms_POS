<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Sales History</h2>
            <p class="text-muted mb-0">
                View all completed transactions
            </p>
        </div>

        <a href="<?= base_url('sales') ?>" class="btn btn-primary">
            New Sale
        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>Sale ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Staff</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($sales)): ?>

                            <?php foreach ($sales as $sale): ?>

                                <tr>

                                    <td>
                                        #<?= $sale['id'] ?>
                                    </td>

                                    <td>
                                        <?= esc($sale['product_name']) ?>
                                    </td>

                                    <td>
                                        <?= $sale['customer_name']
                                            ? esc($sale['customer_name'])
                                            : 'Walk-in Customer'
                                        ?>
                                    </td>

                                    <td>
                                        <?= esc($sale['staff_name']) ?>
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

                                    <td>
                                        <?= date(
                                            'M d, Y h:i A',
                                            strtotime($sale['created_at'])
                                        ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >
                                    No sales recorded yet.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>