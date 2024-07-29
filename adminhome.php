<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Date = $_POST['date'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT p.product_id, p.product_name, p.unit_price, count(o.product_id) as total_number
                            FROM `order` o
                            JOIN product p ON o.product_id = p.product_id 
                            WHERE DATE(order_date) = ?
                            GROUP BY p.product_id");

    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("s", $Date);

    // Execute the statement
    if (!$stmt->execute()) {
        die("Error in executing statement: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    if (!$result) {
        die("Error in getting result: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="adminhome.css">
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <div class="nav-container">
        <nav>
            <li class="nav"><a href="adminhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="ADManageCategory.php" class="nav-links" id="cart">Manage Categories</a></li>
            <li class="nav"><a href="ADAddDiscount.php" class="nav-links" id="support">Add Discount</a></li>
            <li class="nav"><a href="ADManageitems.php" class="nav-links" id="account">Manage Items</a></li>
            <li class="nav"><a href="ADManageEmployees.php" class="nav-links" id="account">Manage Employees</a></li>
            <li class="nav"><a href="ViewWarehouse.php" class="nav-links" id="login">View Warehouse</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="account"><ion-icon name="exit-outline"></ion-icon></a></li>
        </nav>
    </div>

    <div class="logo">
        <img src="images/logo.png" alt="" height="250px">
    </div>
    <br><br><br>

    <form action="adminhome.php" method="post">
        <h1>Daily Sales</h1> <br>
        <input type="date" name="date" id="date"> <br><br>
        <button type="submit">Show Sales</button>
    </form> <br><br><br>    

    <?php
    // Display the results
    if (isset($result) && $result->num_rows > 0) {
        echo "<table>";
        echo "  
          <tr>
              <th>Product Id</th>
              <th>Product Name</th> 
              <th>Number of Sold Products</th>
              <th>Product Unit Price</th>
              <th>Total Sales</th>
          </tr>
          ";
        while ($row = $result->fetch_assoc()) {
            $total = $row['total_number'] * $row['unit_price'];
            echo "<tr>
                    <td>{$row['product_id']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['total_number']}</td>
                    <td>\${$row['unit_price']}</td>
                    <td>\${$total}</td>
                  </tr>";
        }
        echo "</table>";
    }
    
    ?>

</body>

</html>