<?php
session_start();
include "conn.php";

if (!isset($_SESSION['id'])) {
  echo "You need to log in to add items to the cart.";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customer_id = $_SESSION['id'];
  $product_id = $_POST['product_id'];

  $quantity = 1; 
  $stmt1 = $conn->prepare("SELECT unit_price FROM product WHERE product_id = ?");
  $stmt1->bind_param("i", $product_id);
  $stmt1->execute();
  $res = $stmt1->get_result();

  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $unit_price = $row['unit_price'];

    // Check if the product is already in the cart
    $stmt2 = $conn->prepare("SELECT quantity FROM cart WHERE customer_id = ? AND product_id = ?");
    $stmt2->bind_param("ii", $customer_id, $product_id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();

    if ($res2->num_rows > 0) {
      // Update the quantity and total price if the product is already in the cart
      $cart_row = $res2->fetch_assoc();
      $new_quantity = $cart_row['quantity'] + $quantity;
      $total_price = $new_quantity * $unit_price;

      $stmt3 = $conn->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE customer_id = ? AND product_id = ?");
      $stmt3->bind_param("iiii", $new_quantity, $total_price, $customer_id, $product_id);
      $stmt3->execute();
    } else {
      // Insert the new product into the cart
      $total_price = $quantity * $unit_price;

      $stmt3 = $conn->prepare("INSERT INTO cart (customer_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
      $stmt3->bind_param("iiii", $customer_id, $product_id, $quantity, $total_price);
      $stmt3->execute();
    }

    echo "<script>
      alert('Product added to cart.');
      window.location.href = 'customerCart.php';
    </script>";
  } else {
    echo "<script>
      alert('Product not found.');
      window.location.href = 'customerhome.php';
    </script>";
  }
}
?>
