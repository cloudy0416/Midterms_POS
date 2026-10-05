<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Customers</h2>
            <p class="text-muted">Manage your POS customers.</p>
        </div>

        <a href="<?= base_url('customers/create') ?>" class="btn btn-primary">
            + Add Customer
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

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($customers)): ?>

                        <?php foreach ($customers as $customer): ?>

                            <tr>
                                <td><?= esc($customer['id']) ?></td>

                                <td>
                                    <?= esc($customer['full_name']) ?>
                                </td>

                                <td>
                                    <?= esc($customer['email']) ?>
                                </td>

                                <td>
                                    <?= esc($customer['phone']) ?>
                                </td>

                                <td>
                                    <?= esc($customer['created_at']) ?>
                                </td>

                                <td>

                                    <a
                                        href="<?= base_url('customers/edit/' . $customer['id']) ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="<?= base_url('customers/delete/' . $customer['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this customer?');"
                                    >
                                        Delete
                                    </a>

                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No customers found.
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