<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>POS System - Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 12px;
        }

        .login-title {
            font-weight: 700;
        }

        .login-subtitle {
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="card login-card shadow">

    <div class="card-body p-4">

        <div class="text-center mb-4">

            <h2 class="login-title">
                POS System
            </h2>

            <p class="login-subtitle">
                Staff Login
            </p>

        </div>

        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>

        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>

        <?php endif; ?>

        <form action="<?= base_url('login/authenticate') ?>" method="post">

            <?= csrf_field() ?>

            <div class="mb-3">

                <label class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Enter username"
                    value="<?= old('username') ?>"
                    required
                    autofocus
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter password"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn btn-primary w-100"
            >
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>