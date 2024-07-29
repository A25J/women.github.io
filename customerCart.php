<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in... '); window.location.href = 'Loginform.php';</script>";
    exit();
}

$customer_id = $_SESSION['id'];

// Fetch the cart items for the designer
$stmt = $conn->prepare("SELECT cart.*, product.product_name, product.product_image, product.unit_price FROM cart JOIN product ON cart.product_id = product.product_id WHERE cart.customer_id = ?");
$stmt->bind_param('i', $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}
$stmt->close();
$conn->close();

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['unit_price'] * $item['quantity'];
}
$tax = $subtotal * 0.05;
$shipping = 3.00;
$grand_total = $subtotal + $tax + $shipping;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
</head>

<body>
<nav>
        <ul class="nav-bar">
            <li class="nav"><a href="customerhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="customerCart.php" class="nav-links" id="cart">Cart</a></li>
            <li class="nav"><a href="bodyy.php" class="nav-links" id="support">Get Support</a></li>
            <li class="nav"><a href="customerTrackOrder.php" class="nav-links" id="track">Track order</a></li>
            <li class="nav">
                <?php 
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php" class="nav-links" id="login">Logout</a>';
                } else {
                    echo '<a href="Loginform.php" class="nav-links" id="login">Login</a>';
                }
                ?>
            </li>
            <li class="nav"><a href="customerAccount.php" class="nav-links" id="account">Account</a></li>
        </ul>
    </nav>
    <h1>Shopping Cart</h1>
    <div class="shopping-cart">
        <?php foreach ($cart_items as $item) : ?>
            <div class="product" data-id="<?php echo $item['cart_id']; ?>">
                <div class="product-image">
                    <img src="images/products/<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product Image">
                </div>
                <div class="product-details">
                    <div class="product-title"><?php echo htmlspecialchars($item['product_name']); ?></div>
                </div>
                <div class="product-price"><?php echo $item['unit_price']; ?></div>
                <div class="product-quantity">
                    <?php echo htmlspecialchars($item['quantity']); ?>
                </div>
                <div class="product-removal">
                    <button class="remove-product" data-id="<?php echo $item['cart_id']; ?>">Remove</button>
                </div>
                <div class="product-line-price"><?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></div>
            </div>
        <?php endforeach; ?>
        <div class="totals">
            <div class="totals-item">
                <label>Subtotal</label>
                <div class="totals-value" id="cart-subtotal"> $ <?php echo number_format($subtotal, 2); ?></div>
            </div>
            <div class="totals-item">
                <label>Tax (5%)</label>
                <div class="totals-value" id="cart-tax"> $ <?php echo number_format($tax, 2); ?></div>
            </div>
            <div class="totals-item">
                <label>Shipping</label>
                <div class="totals-value" id="cart-shipping">$3.00</div>
            </div>
            <div class="totals-item totals-item-total">
                <label>Grand Total</label>
                <div class="totals-value" id="cart-total"> $ <?php echo number_format($grand_total, 2); ?></div>
            </div>
        </div>
        <button class="checkout">Checkout</button>
    </div>
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Checkout</h2>
            <form id="checkoutForm" action="process_order.php" method="POST">
                <label>Enter your location:</label>
                <input type="text" id="location" name="location" required>
                <h3>Select Payment Method:</h3>
                <label>
                    <input type="radio" name="payment_method" value="cash" required>
                    Cash on Delivery
                </label>
                <label>
                    <input type="radio" name="payment_method" value="credit" required>
                    Credit Card
                </label> <br> <br><br><br>  
                <button type="submit" name="submit" onclick="payment()">Confirm Order</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var taxRate = 0.05;
            var shippingRate = 15.00;
            var fadeTime = 300;

            $('.product-quantity input').change(function() {
                updateQuantity(this);
            });

            $('.product-removal button').click(function() {
                removeItem(this);
            });

            function recalculateCart() {
                var subtotal = 0;

                $('.product').each(function() {
                    subtotal += parseFloat($(this).children('.product-line-price').text());
                });

                var tax = subtotal * taxRate;
                var shipping = (subtotal > 0 ? shippingRate : 0);
                var total = subtotal + tax + shipping;

                $('.totals-value').fadeOut(fadeTime, function() {
                    $('#cart-subtotal').html(subtotal.toFixed(2));
                    $('#cart-tax').html(tax.toFixed(2));
                    $('#cart-shipping').html(shipping.toFixed(2));
                    $('#cart-total').html(total.toFixed(2));
                    if (total == 0) {
                        $('.checkout').fadeOut(fadeTime);
                    } else {
                        $('.checkout').fadeIn(fadeTime);
                    }
                    $('.totals-value').fadeIn(fadeTime);
                });
            }

            function updateQuantity(quantityInput) {
                var productRow = $(quantityInput).parent().parent();
                var price = parseFloat(productRow.children('.product-price').text());
                var quantity = $(quantityInput).val();
                var linePrice = price * quantity;

                productRow.children('.product-line-price').each(function() {
                    $(this).fadeOut(fadeTime, function() {
                        $(this).text(linePrice.toFixed(2));
                        recalculateCart();
                        $(this).fadeIn(fadeTime);
                    });
                });
            }

            function removeItem(removeButton) {
                var productRow = $(removeButton).parent().parent();
                productRow.slideUp(fadeTime, function() {
                    productRow.remove();
                    recalculateCart();
                });
            }
        });
    </script>
   <script>
    $(document).ready(function() {
        // Handle product removal
        $(".remove-product").click(function() {
            var cart_id = $(this).data('id');
            var $product = $(this).closest('.product');

            $.ajax({
                url: 'remove_from_cart.php',
                type: 'POST',
                data: {
                    cart_id: cart_id
                },
                success: function(response) {
                    if (response.trim() === 'success') {
                        $product.remove();
                        updateTotals();
                    } else {
                        alert('Failed to remove the product.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                    alert('An error occurred while removing the product. Please try again.');
                }
            });
        });

        // Handle order processing
        function processOrder() {
            var paymentMethod = $('input[name="payment_method"]:checked').val();
            var location = $('#location').val();

            if (paymentMethod) {
                $.ajax({
                    url: 'process_order.php',
                    type: 'POST',
                    data: {
                        payment_method: paymentMethod,
                        location: location
                    },
                    success: function(response) {
                        if (response.trim() === 'success') {
                            if (paymentMethod === 'cash') {
                                window.location.href = 'customerhome.php'; // Redirect to customer home
                                exit;
                            } else if (paymentMethod === 'credit') {
                                window.location.href = 'customercard.php'; // Redirect to card page
                                exit;
                            }
                        } 
                        $('#checkoutModal').hide(); // Hide modal only after the request completes
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                        alert('An error occurred while processing your request. Please try again.');
                        $('#checkoutModal').hide(); // Hide modal even if there is an error
                    }
                });
            } else {
                alert('Please select a payment method.');
            }
        }

        $('#checkout-button').click(processOrder);

        $('#checkoutForm').submit(function(event) {
            event.preventDefault();
            processOrder();
        });

        // Modal handling
        var modal = $('#checkoutModal');
        var btn = $('.checkout');
        var span = $('.close');

        btn.click(function() {
            modal.show();
        });

        span.click(function() {
            modal.hide();
        });

        $(window).click(function(event) {
            if (event.target == modal[0]) {
                modal.hide();
            }
        });
    });
</script>

<script>
    function payment() {
    var paymentMethod = $('input[name="payment_method"]:checked').val();
    var customerid = <?php echo $_SESSION['id']; ?>;

    if (paymentMethod === 'cash') {
        window.location.href = 'customerhome.php';
    } else {
        window.location.href = 'customerCard.php';
    }

    $.ajax({
        url: 'process_order.php',
        type: 'POST',
        data: {
            payment_method: paymentMethod,
            customerid: customerid
        },
        success: function(response) {
        },
        error: function(xhr, status, error) {
            alert('error');
        }
    });
}

            
</script>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 0 30px 30px 20px;
            background-color: rgb(202, 202, 171);
        }

        h1 {
            font-weight: 100;
        }

        label {
            color: #aaa;
        }

        nav {
            width: 100%;
            margin-bottom: 20px;
        }

        .nav-bar {
            list-style: none;
            display: flex;
            justify-content: flex-end;
            margin: 0;
            padding: 0;
        }

        .nav {
            padding: 15px;
        }

        .nav-links {
            color: black;
            text-decoration: none;
            padding: 15px 20px;
            position: relative;
        }

        .nav-links::after {
            content: "";
            display: block;
            height: 4px;
            left: 50%;
            position: absolute;
            background: black;
            transition: width 0.5s ease, left 0.5s ease;
            width: 0%;
        }

        .nav-links:hover::after {
            width: 100%;
            left: 0%;
            background-color: rgb(88, 154, 173);
        }

        .shopping-cart {
            margin-top: 45px;
        }

        .column-labels label {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .product {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .product-image {
            flex: 0 0 20%;
            text-align: center;
        }

        .product-image img {
            width: 100px;
        }

        .product-details {
            flex: 0 0 37%;
            text-align: left;
        }

        .product-title {
            margin-bottom: 5px;
        }

        .product-price,
        .product-quantity,
        .product-removal,
        .product-line-price {
            flex: 0 0 12%;
            text-align: center;
        }

        .product-quantity input {
            width: 40px;
            text-align: center;
        }

        .product-removal button {
            color: #fff;
            background: #e53935;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .product-removal button:hover {
            background: #b71c1c;
        }

        .totals {
            margin-top: 30px;
            text-align: right;
        }

        .totals-item {
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .totals-item label {
            padding-right: 20px;
            text-transform: uppercase;
        }

        .totals-value {
            display: inline-block;
            min-width: 80px;
            text-align: right;
        }

        .checkout {
            margin-top: 20px;
            padding: 10px 50px;
            background-color: darkcyan;
            border: none;
            color: #000;
            font-size: 1.2em;
            text-transform: uppercase;
            cursor: pointer;
        }

        .checkout:hover {
            background-color: #aaa;
            border: 2px darkcyan;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 20px;
            height: 300px;
        }
        .modal-content button{
            border-radius: 30px;
            font-size: 20px;
            width: 50%;
            height: 50px;
        }
        .modal-content button:hover{
            background-color: darkcyan;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
    </style>
</body>

</html>
