<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
session_start();
include('conn.php');
include "mailerscript.php";

$sql = "SELECT * FROM `order`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update customer's order status</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
</head>

<body>
    <nav>
        <ul class="nav-bar">
            <li class="nav"><a href="warehouseSpecialist.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="updateitems.php" class="nav-links" id="update-items">Update Number of Items</a></li>
            <li class="nav"><a href="WaddItems.php" class="nav-links" id="add-items">Add Items</a></li>
            <li class="nav"><a href="WUpdateStatus.php" class="nav-links" id="add-items">Update order status</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="add-items">Logout</a></li>
        </ul>
    </nav>

    <table>
        <tr>
            <th>Order id</th>
            <th>Customer id</th>
            <th>Product id</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Order Date</th>
            <th>Location</th>
            <th>Order Status</th>
        </tr>
        <?php
        while ($row = $res->fetch_assoc()) {
            echo "<tr><td>"
                . $row['order_id'] .
                "</td><td>"
                . $row['customer_id'] .
                "</td><td>"
                . $row['product_id'] .
                "</td><td>"
                . $row['total_price'] .
                "</td><td>"
                . $row['payment_method'] .
                "</td><td>"
                . $row['order_date'] .
                "</td><td>"
                . $row['location'] .
                "</td><td>";
            echo "<form method='POST' action=''>
            <input type='hidden' name='order_id' value='{$row['order_id']}'";
            echo $row['order_id'];
        ?>
            <form method="POST" action="">
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                <select name="order_status" onchange="this.form.submit()">
                    <option value="Pending" <?php if ($row['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Shipped" <?php if ($row['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                </select>
            </form>

        <?php } ?>

    </table>
</body>

</html>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        vertical-align: middle;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;

        overflow: hidden;
    }

    nav {
        float: right;
        margin-right: 5px;
    }

    .nav-bar {
        list-style: none;
        display: table;
        text-align: center;
    }

    .nav {
        display: table-cell;
        position: relative;
        padding: 15px 0;
        font-family: "Arial", sans-serif;
    }

    .nav-links {
        color: #000000;
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

    /* Media Query for smaller screens */
    @media screen and (max-width: 768px) {
        .logo {
            width: 60%;
        }
    }

    /* Media Query for even smaller screens */
    @media screen and (max-width: 480px) {
        .logo {
            width: 80%;
        }
    }

    table {
        display: flex;
        justify-content: center;
        align-items: center;
        border-collapse: separate;
        border-spacing: 10px;
        font-size: 18px;
        width: 100vw;
        text-align: center;
    }

    tr {
        text-align: center;

    }

    td {
        text-align: center;
        padding: 12px;
        margin: 12px;
        align-items: center;
    }
</style>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['order_status'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Update order status in the database
    $stmt = $conn->prepare("UPDATE `order` SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();

    if ($order_status == 'shipped') {
        // Fetch customer email and order details
        $stmt = $conn->prepare("SELECT customer_email FROM customer_id = ?");
        $stmt->bind_param("i", $row['customer_id']);
        $stmt->execute();
        $result1 = $stmt->get_result();
        $row1 = $result1->fetch_assoc();
        $customer_email = $row1['customer_email'];
       
        $message = "Dear customer, <br><br> Your order with order id ".$order_id . "has been shipped.<br> Please note that 
                    delivery takes up to 3 days";
        $subject = "Order has been shipped!";

        
        // Send email notification to the customer
        if (sendEmail($customer_email, $subject, $message)) {
            echo "<script>alert(Email sent successfully to {$row1['customer_email']}); </script>";
        } else {
            echo "<script>alert(Failed to send email to {$row1['customer_email']}); </script>";
        }
    }
}
?>