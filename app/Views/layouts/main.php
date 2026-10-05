<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= $title ?? 'POS System' ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
    rel="stylesheet"
    href="<?= base_url('css/style.css') ?>"
>

</head>

<body>

    <?= $this->include('layouts/sidebar') ?>

    <div class="main-content">

        <?= $this->include('layouts/topbar') ?>

        <main class="p-4">

            <?= $this->renderSection('content') ?>

        </main>

    </div>


    <?= $this->include('layouts/footer') ?>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>