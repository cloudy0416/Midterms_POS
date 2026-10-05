<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="mb-4">
        <h2>Add Customer</h2>
        <p class="text-muted">Register a new customer.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (isset($validation)): ?><div class="alert alert-danger"><?= $validation->listErrors() ?></div><?php endif; ?>

            <form action="<?= base_url('customers/store') ?>" method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        class="form-control"
                        placeholder="Enter customer's full name"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter email address"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        placeholder="Enter phone number"
                        required
                    >
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Save Customer
                    </button>

                    <a href="<?= base_url('customers') ?>" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
