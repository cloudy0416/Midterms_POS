<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <!-- Receipt Header -->

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            POS SYSTEM
                        </h2>

                        <p class="text-muted mb-0">
                            Official Sales Receipt
                        </p>

                        <hr>

                    </div>


                    <!-- Receipt Information -->

                    <div class="row mb-4">

                        <div class="col-6">

                            <strong>Receipt #:</strong><br>

                            #<?= $sale['id'] ?>

                        </div>

                        <div class="col-6 text-end">

                            <strong>Date:</strong><br>

                            <?= date(
                                'M d, Y h:i A',
                                strtotime($sale['created_at'])
                            ) ?>

                        </div>

                    </div>


                    <div class="mb-4">

                        <strong>Customer:</strong>

                        <?= $sale['customer_name']
                            ? esc($sale['customer_name'])
                            : 'Walk-in Customer'
                        ?>

                        <br>

                        <strong>Cashier:</strong>

                        <?= esc($sale['staff_name']) ?>

                    </div>


                    <!-- Product -->

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead class="table-light">

                                <tr>

                                    <th>
                                        Product
                                    </th>

                                    <th class="text-center">
                                        Qty
                                    </th>

                                    <th class="text-end">
                                        Price
                                    </th>

                                    <th class="text-end">
                                        Total
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>
                                        <?= esc($sale['product_name']) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $sale['quantity'] ?>
                                    </td>

                                    <td class="text-end">

                                        ₱<?= number_format(
                                            $sale['product_price'],
                                            2
                                        ) ?>

                                    </td>

                                    <td class="text-end">

                                        ₱<?= number_format(
                                            $sale['total_price'],
                                            2
                                        ) ?>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <!-- Total -->

                    <div class="row justify-content-end">

                        <div class="col-md-6">

                            <div class="d-flex justify-content-between">

                                <strong>
                                    Total:
                                </strong>

                                <strong>
                                    ₱<?= number_format(
                                        $sale['total_price'],
                                        2
                                    ) ?>
                                </strong>

                            </div>

                        </div>

                    </div>


                    <hr>


                    <!-- Buttons -->

                    <div class="d-flex gap-2 justify-content-center mt-4">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="window.print()"
                        >
                            Print Receipt
                        </button>

                        <a
                            href="<?= base_url('sales') ?>"
                            class="btn btn-success"
                        >
                            New Sale
                        </a>

                        <a
                            href="<?= base_url('sales/history') ?>"
                            class="btn btn-secondary"
                        >
                            Sales History
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

@media print
{
    body *
    {
        visibility: hidden;
    }

    .card,
    .card *
    {
        visibility: visible;
    }

    .card
    {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }

    button,
    a
    {
        display: none !important;
    }
}

</style>

<?= $this->endSection() ?>