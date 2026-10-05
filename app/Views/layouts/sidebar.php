<aside class="sidebar">

    <div class="sidebar-logo">
        <h2>POS SYSTEM</h2>
        <p>Point of Sale Management</p>
    </div>

    <nav class="sidebar-menu">

        <div class="menu-title">Main Menu</div>

        <a href="<?= base_url('dashboard') ?>">
            <span>Dashboard</span>
        </a>

        <div class="menu-title">Management</div>

        <a href="<?= base_url('products') ?>">
            <span>Products</span>
        </a>

        <a href="<?= base_url('customers') ?>">
            <span>Customers</span>
        </a>

        <a href="<?= base_url('users') ?>">
            <span>Staff</span>
        </a>

        <div class="menu-title">Sales</div>

        <a href="<?= base_url('sales/create') ?>">
            <span>Record Sale</span>
        </a>

        <a href="<?= base_url('logout') ?>" class="logout-link">
            <span>Logout</span>
        </a>

    </nav>
    

</aside>
