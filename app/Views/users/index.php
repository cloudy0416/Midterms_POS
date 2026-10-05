<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Users</h2>
            <p class="text-muted">Manage POS staff accounts.</p>
        </div>

        <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
            + Add User
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
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($users)): ?>

                        <?php foreach ($users as $user): ?>

                            <tr>
                                <td><?= esc($user['id']) ?></td>

                                <td>
                                    <?php if (!empty($user['avatar'])): ?>
                                        <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="<?= esc($user['full_name']) ?>" width="40" height="40" style="object-fit:cover;border-radius:50%;">
                                    <?php else: ?>
                                        <span class="text-muted">None</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= esc($user['username']) ?>
                                </td>

                                <td>
                                    <?= esc($user['full_name']) ?>
                                </td>

                                <td>
                                    <?= esc($user['created_at']) ?>
                                </td>

                                <td>

                                    <a
                                        href="<?= base_url('users/edit/' . $user['id']) ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="<?= base_url('users/delete/' . $user['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this user?');"
                                    >
                                        Delete
                                    </a>

                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No users found.
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
