<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="mb-4">
        <h2>Edit User</h2>
        <p class="text-muted">Update the staff account.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (isset($validation)): ?><div class="alert alert-danger"><?= $validation->listErrors() ?></div><?php endif; ?>
            <form
                action="<?= base_url('users/update/' . $user['id']) ?>"
                method="post"
                enctype="multipart/form-data"
            >

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Username</label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="<?= esc($user['username']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        class="form-control"
                        value="<?= esc($user['full_name']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        New Password
                        <small class="text-muted">(leave blank to keep current password)</small>
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter new password"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Avatar</label>

                    <input
                        type="file"
                        name="avatar"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                    >
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        Update User
                    </button>

                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
