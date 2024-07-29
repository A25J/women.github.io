<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You have to login first '); window.location.href = 'Loginform.php';</script>";
    exit();
}
$customer_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$resl = $stmt->get_result();
$row1 = $resl->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <style>
        nav {
            position: relative;
            flex-wrap: wrap;
            width: 100vw;
            margin-right: 5px;
            float: right;
        }
        .nav-bar {
            position: relative;
            list-style: none;
            display: table;
            text-align: center;
            float: right;
        }
        .nav {
            display: table-cell;
            position: sticky;
            padding: 15px 0;
            font-family: "Arial", sans-serif;
        }
        .nav-links {
            color: black;
            text-decoration: none;
            display: inline-block;
            padding: 15px 20px;
            position: relative;
        }
        .nav-links::after {
            content: "";
            background: none repeat scroll 0 0 transparent;
            display: block;
            height: 4px;
            left: 50%;
            position: absolute;
            background: black;
            transition: width 0.5s ease 0s, left 0.5s ease 0s;
            width: 0%;
            margin: 4px;
        }
        .nav-links:hover::after {
            width: 100%;
            left: 0%;
            background-color: rgb(88, 154, 173);
        }
        @media screen and (max-width: 768px) {
            .logo {
                width: 150px;
            }
            .card {
                width: 100%;
            }
        }
        @media screen and (max-width: 480px) {
            .nav-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .nav {
                display: block;
                padding: 10px 0;
                text-align: center;
                display: none;
            }
            .nav-links {
                display: block;
                padding: 10px 0;
            }
            .logo-container {
                padding: 10px;
            }
            .card {
                width: 100%;
            }
        }
        p {
            font-size: 1.2rem;
            margin: 10px;
            padding: 10px;
        }
        .account-container {
            display: flex;
            background-color: transparent;
            border: 2px solid lavenderblush;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
        }
        .left-side,
        .right-side {
            padding: 20px;
        }
        .left-side {
            border-right: 1px solid #ddd;
        }
        #profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: block;
            margin-bottom: 10px;
        }
        #update-picture {
            display: block;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .right-side {
            flex-grow: 1;
        }
        .view-order {
            display: block;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .view-order:hover {
            background-color: #218838;
        }
        .order-details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        .hidden {
            display: none;
        }
        body {
            background-color: beige;
        }
    </style>
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
    <div class="account-container">
        <div class="left-side">
            <img src="cutomerimages/<?php echo $row1['customer_pic']; ?>" alt="Profile Picture" id="profile-picture"><br><br>
            <pre><?php echo $row1['customer_username']; ?></pre>
            <form action="updateimage.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image" id="update-picture" required>
                <button name="image">Update image</button>
            </form>
        </div>
        <div class="right-side">
            <?php
            $sql = "SELECT * FROM `order` WHERE customer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $ord_id = htmlspecialchars($row['order_id']);
                    $loc = htmlspecialchars($row['location']);
                    $totalprice = htmlspecialchars($row['total_price']);
                    $date = htmlspecialchars($row['order_date']);
                    $status = htmlspecialchars($row['order_status']);
                    ?>
                    <h3>Order Details</h3>
                    <p>Order ID: <?php echo $ord_id; ?></p>
                    <button class="view-order" data-order-id="<?php echo $ord_id; ?>">View Order</button>
                    <div id="order-details-<?php echo $ord_id; ?>" class="order-details hidden">
                        <p>Date: <?php echo $date; ?></p>
                        <p>Status: <?php echo $status; ?></p>
                        <p>Sent to location: <?php echo $loc; ?></p>
                        <p>Total price: <?php echo $totalprice; ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No orders found.</p>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
    <script>
        document.querySelectorAll('.view-order').forEach(button => {
            button.addEventListener('click', function() {
                var orderId = this.getAttribute('data-order-id');
                var orderDetails = document.getElementById('order-details-' + orderId);
                orderDetails.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
