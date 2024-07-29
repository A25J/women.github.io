<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <?php
    include "conn.php";
    session_start();
    ?>
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
    <div class="content-container">
        <section>
            <form action="customerTrackOrder.php" method="post">
                <input type="text" name="orderID" placeholder="Enter your order ID" required>
                <input type="submit" name="submit" value="Track Order">
            </form>
        </section>
    </div>
</body>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        background-repeat: no-repeat;
        background-size: cover;
        overflow-x: hidden;
        background-attachment: fixed;
        width: 100vw;
        height: 100vh;
    }

    nav {
        width: 100%;
    }

    .nav-bar {
        list-style: none;
        display: flex;
        justify-content: flex-end;
        margin: 0;
        padding: 0;
    }

    .nav {
        padding: 15px 0;
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
        width: 0;
    }

    .nav-links:hover::after {
        width: 100%;
        left: 0;
        background-color: black;
    }

    .content-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: relative;
        top: 15%;
        width: 70%;
        margin-left: 250px;
    }

    

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input[type="text"],
    input[type="submit"] {
        padding: 10px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    table {
        position: relative;
        top: 15%;
        width: 70%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-left: 250px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }
</style>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
        $orderID = $_POST['orderID'];
        $sql = "SELECT * FROM `order` WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();
        $nb = $result->num_rows;
        $row = $result->fetch_assoc();
        if ($row['customer_id'] === $_SESSION['id']) {
            if ($nb > 0) {
                echo "<table>";
                echo "<tr>
                      <th>Order Id</th>
                      <th>Location</th>
                      <th>Total Price</th>
                      <th>Payment Method</th>
                      <th>Order Date</th>
                      <th>Order Status</th>
                  </tr>";
                
                    echo "<tr>
                          <td>" . $row['order_id'] . "</td>
                          <td>" . $row['location'] . "</td>
                          <td>" . $row['total_price'] . "</td>
                          <td>" . $row['payment_method'] . "</td>
                          <td>" . $row['order_date'] . "</td>
                          <td>" . $row['order_status'] . "</td>
                      </tr>";
                
                echo "</table>";
            } else {
                echo "<script>alert('Order not found, please enter a valid order id'); window.location.href = 'customerTrackOrder.php';</script>";
            }
        }
    }
    ?>


</html>