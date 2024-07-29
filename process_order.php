<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in.'); window.location.href = 'Loginform.php';</script>";
    exit();
}
print_r($_POST);
$customer_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $location = $_POST['location'];
    $payment_method = $_POST['payment_method'];
    $order_date = date('Y-m-d H:i:s');

    // Fetch cart items with product details
    $stmt = $conn->prepare("SELECT cart.product_id, cart.quantity, product.unit_price 
                            FROM cart 
                            JOIN product ON cart.product_id = product.product_id 
                            WHERE cart.customer_id = ?");
    if (!$stmt) {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        exit();
    }

    $stmt->bind_param('i', $customer_id);
    if (!$stmt->execute()) {
        echo "<script>alert('Error executing statement: " . $stmt->error . "');</script>";
        exit();
    }

    $result = $stmt->get_result();
    if (!$result) {
        echo "<script>alert('Error getting result: " . $stmt->error . "');</script>";
        exit();
    }

    $total_price = 0;
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price += $row['quantity'] * $row['unit_price'];
    }
    $stmt->close();

    if ($payment_method === 'cash') {
        // Process cash on delivery
        $stmt = $conn->prepare("INSERT INTO `order` (customer_id, product_id, `location`, total_price, order_date, payment_method, order_status) VALUES (?, ?, ?, ?, ?, 'cash', 'pending')");
        if (!$stmt) {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
            exit();
        }

        foreach ($cart_items as $item) {
            $stmt->bind_param('iisds', $customer_id, $item['product_id'], $location, $total_price, $order_date);
            if (!$stmt->execute()) {
                echo "<script>alert('Error executing statement: " . $stmt->error . "');</script>";
                exit();
            }
        }
        $stmt->close();

        // Clear the cart
        $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
        if (!$stmt) {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
            exit();
        }
        $stmt->bind_param('i', $customer_id);
        if (!$stmt->execute()) {
            echo "<script>alert('Error executing statement: " . $stmt->error . "');</script>";
            exit();
        }
        $stmt->close();

        echo "<script. window.location.href = 'customerhome.php';</script>";
    } elseif ($payment_method === 'credit') {
        // Check if the customer has added credit card information
        $stmt = $conn->prepare("SELECT expiration_date FROM card_info WHERE customer_id = ?");
        $stmt->bind_param('i', $customer_id);
        if (!$stmt->execute()) {
            echo "<script>alert('Error executing statement: " . htmlspecialchars($stmt->error) . "');</script>";
            exit();
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $card = $result->fetch_assoc();
            $expiry_date = $card['expiration_date'];
            $current_date = date('Y-m-d H:i:s');

            if ($expiry_date < $current_date) {
                echo "<script>alert('Your credit card has expired. Please update your card information.'); window.location.href = 'customercard.php';</script>";
                exit();
            } else {
                // Process credit card payment
                $stmt = $conn->prepare("INSERT INTO `order` (customer_id, product_id, `location`, total_price, order_date, payment_method, order_status) VALUES (?, ?, ?, ?, ?, 'credit', 'pending')");
                foreach ($cart_items as $item) {
                    $stmt->bind_param('iisis', $customer_id, $item['product_id'], $location, $total_price, $order_date);
                    $stmt->execute();
                }
                $stmt->close();

                // Clear the cart
                $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
                if (!$stmt) {
                    echo "<script>alert('Error preparing statement: " . htmlspecialchars($conn->error) . "');</script>";
                    exit();
                }
                $stmt->bind_param('i', $customer_id);
                if (!$stmt->execute()) {
                    echo "<script>alert('Error executing statement: " . htmlspecialchars($stmt->error) . "');</script>";
                    exit();
                }
                $stmt->close();

                header("Location: customerhome.php");
                exit();
            }
        } else {
            echo "<script>alert('No credit card information found. Please add your credit card details.'); window.location.href = 'customercard.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid payment method selected.');</script>";
        exit();
    }
} else {
    echo "<script>alert('Error occurred while processing your request.');</script>";
    exit();
}

$conn->close();
?>
