<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <?= session()->getFlashdata('success') ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <?= session()->getFlashdata('error') ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

<?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Point of Sale</h2>
            <p class="text-muted mb-0">Create a new sales transaction</p>
        </div>

        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-7">

            <div class="card shadow-sm mb-4">

                <div class="card-header">
                    <h5 class="mb-0">Product Selection</h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Customer</label>

                        <select class="form-select" id="customer">
                            <option value="">Walk-in Customer</option>

                            <?php foreach ($customers as $customer): ?>

                                <option value="<?= $customer['id'] ?>">
                                    <?= esc($customer['full_name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>


                    <div class="mb-3">

                        <label class="form-label">Product</label>

                        <select class="form-select" id="product">

                            <option value="">Select Product</option>

                            <?php foreach ($products as $product): ?>

                                <option
                                    value="<?= $product['id'] ?>"
                                    data-name="<?= esc($product['name']) ?>"
                                    data-price="<?= $product['price'] ?>"
                                    data-stock="<?= $product['stock_quantity'] ?>"
                                >
                                    <?= esc($product['name']) ?>
                                    - ₱<?= number_format($product['price'], 2) ?>
                                    (Stock: <?= $product['stock_quantity'] ?>)
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <label class="form-label">Quantity</label>

                            <input
                                type="number"
                                class="form-control"
                                id="quantity"
                                value="1"
                                min="1"
                            >

                        </div>

                        <div class="col-md-6 d-flex align-items-end">

                            <button
                                type="button"
                                class="btn btn-primary w-100"
                                onclick="addToCart()"
                            >
                                Add to Cart
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            <!-- CART -->

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">Shopping Cart</h5>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead class="table-light">

                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th width="100">Qty</th>
                                    <th>Total</th>
                                    <th width="80">Action</th>
                                </tr>

                            </thead>

                            <tbody id="cartBody">

                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No products added to cart.
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <!-- RIGHT SIDE -->

        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">Payment</h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="fw-bold">
                            Total Amount
                        </span>

                        <span
                            class="fw-bold fs-4"
                            id="totalAmount"
                        >
                            ₱0.00
                        </span>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Payment
                        </label>

                        <input
                            type="number"
                            class="form-control form-control-lg"
                            id="payment"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            oninput="calculateChange()"
                        >

                    </div>


                    <div class="d-flex justify-content-between mb-4">

                        <span class="fw-bold">
                            Change
                        </span>

                        <span
                            class="fw-bold fs-4 text-success"
                            id="changeAmount"
                        >
                            ₱0.00
                        </span>

                    </div>


                    <button
                        type="button"
                        class="btn btn-success btn-lg w-100"
                        onclick="processSale()"
                    >
                        Complete Sale
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

let cart = [];


function addToCart()
{
    const productSelect = document.getElementById('product');
    const quantityInput = document.getElementById('quantity');

    const selectedOption =
        productSelect.options[productSelect.selectedIndex];

    if (!selectedOption.value)
    {
        alert('Please select a product.');
        return;
    }

    const productId = selectedOption.value;
    const name = selectedOption.dataset.name;
    const price = parseFloat(selectedOption.dataset.price);
    const stock = parseInt(selectedOption.dataset.stock);
    const quantity = parseInt(quantityInput.value);

    if (quantity <= 0)
    {
        alert('Quantity must be at least 1.');
        return;
    }

    if (quantity > stock)
    {
        alert('Not enough stock available.');
        return;
    }

    const existingProduct = cart.find(
        item => item.id == productId
    );

    if (existingProduct)
    {
        const newQuantity =
            existingProduct.quantity + quantity;

        if (newQuantity > stock)
        {
            alert('Not enough stock available.');
            return;
        }

        existingProduct.quantity = newQuantity;
    }
    else
    {
        cart.push({
            id: productId,
            name: name,
            price: price,
            quantity: quantity,
            stock: stock
        });
    }

    renderCart();

    productSelect.value = '';
    quantityInput.value = 1;
}


function renderCart()
{
    const cartBody = document.getElementById('cartBody');

    cartBody.innerHTML = '';

    if (cart.length === 0)
    {
        cartBody.innerHTML = `
            <tr>
                <td colspan="5"
                    class="text-center text-muted py-4">
                    No products added to cart.
                </td>
            </tr>
        `;

        document.getElementById('totalAmount').innerText =
            '₱0.00';

        calculateChange();

        return;
    }

    let total = 0;

    cart.forEach((item, index) =>
    {
        const itemTotal =
            item.price * item.quantity;

        total += itemTotal;

        cartBody.innerHTML += `
            <tr>

                <td>
                    ${item.name}
                </td>

                <td>
                    ₱${item.price.toFixed(2)}
                </td>

                <td>
                    ${item.quantity}
                </td>

                <td>
                    ₱${itemTotal.toFixed(2)}
                </td>

                <td>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        onclick="removeFromCart(${index})"
                    >
                        Remove
                    </button>

                </td>

            </tr>
        `;
    });

    document.getElementById('totalAmount').innerText =
        '₱' + total.toFixed(2);

    calculateChange();
}


function removeFromCart(index)
{
    cart.splice(index, 1);

    renderCart();
}


function getTotal()
{
    let total = 0;

    cart.forEach(item =>
    {
        total += item.price * item.quantity;
    });

    return total;
}


function calculateChange()
{
    const total = getTotal();

    const payment =
        parseFloat(
            document.getElementById('payment').value
        ) || 0;

    let change = payment - total;

    if (change < 0)
    {
        change = 0;
    }

    document.getElementById('changeAmount').innerText =
        '₱' + change.toFixed(2);
}


function processSale()
{
    if (cart.length === 0)
    {
        alert('Please add at least one product to the cart.');
        return;
    }

    const total = getTotal();

    const payment =
        parseFloat(
            document.getElementById('payment').value
        ) || 0;

    if (payment < total)
    {
        alert('Payment is not enough.');
        return;
    }

    const customerId =
        document.getElementById('customer').value;

    const form = document.createElement('form');

    form.method = 'POST';
    form.action = '<?= base_url('sales/checkout') ?>';

    // CSRF token
    const csrfInput = document.createElement('input');

    csrfInput.type = 'hidden';
    csrfInput.name = '<?= csrf_token() ?>';
    csrfInput.value = '<?= csrf_hash() ?>';

    form.appendChild(csrfInput);


    // Customer
    const customerInput = document.createElement('input');

    customerInput.type = 'hidden';
    customerInput.name = 'customer_id';
    customerInput.value = customerId;

    form.appendChild(customerInput);


    // Cart
    const cartInput = document.createElement('input');

    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(cart);

    form.appendChild(cartInput);


    document.body.appendChild(form);

    form.submit();
}

</script>

<?= $this->endSection() ?>