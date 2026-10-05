<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="mb-4">
        <h2>Edit Customer</h2>
        <p class="text-muted">Update customer information.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (isset($validation)): ?><div class="alert alert-danger"><?= $validation->listErrors() ?></div><?php endif; ?>

            <form
                action="<?= base_url('customers/update/' . $customer['id']) ?>"
                method="post"
            >

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        class="form-control"
                        value="<?= esc($customer['full_name']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= esc($customer['email']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="<?= esc($customer['phone']) ?>"
                        required
                    >
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Update Customer
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
