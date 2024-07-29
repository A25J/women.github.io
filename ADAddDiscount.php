<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Discounts</title>
    <link rel="stylesheet" href="AddDiscount.css">
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>
<body>
    <?php
    include "conn.php";
    session_start();
    ?>
<nav>
            <li class="nav"><a href="adminhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="ADManageCategory.php" class="nav-links" id="cart">Manage Categories</a></li>
            <li class="nav"><a href="ADAddDiscount.php" class="nav-links" id="support">Add Discount</ion-icon></a></li>
            <li class="nav"><a href="ADManageitems.php" class="nav-links" id="account">Manage Items</a></li>
            <li class="nav"><a href="ADManageEmployees.php" class="nav-links" id="account">Manage Employees </a></li>
            <li class="nav"><a href="ViewWarehouse.php" class="nav-links" id="login">View Warehouse</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="account"><ion-icon name="exit-outline"></ion-icon></a></li>
    </nav>

    <section>
    <h1>Manage Discounts</h1>
        <h2>Add Discount <ion-icon name="trending-down-outline"></ion-icon></h2>
        <form action="ADAddDiscount.php" method="post">
            <div class="inputbox">
            <ion-icon name="document-text-outline"></ion-icon>
            <input type="text" required name="discount-description">
            <label for="">Discount description</label>
            </div>
            <select name="discount-category" id="">
                <option value="none">None</option>
                <?php
                
                $stmt = $conn->prepare("SELECT category_name FROM category");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row=$result->fetch_assoc()) {
                    echo "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                }
                ?>
                </select>
               <div class="inputbox">
               <ion-icon name="pricetag-outline"></ion-icon>
            <input type="number" required name="discount-amount">
            <label for="">Discount Amount</label>
            </div>
            
            <button type="submit" name="submit">Add Discount</button>
            </form>
        <hr>
        <form action="ADRemoveDiscount.php" method="post">
    <h2>Remove Discount</h2>
    <select name="remove-discount" id="">
        <option value="none">None</option>
        <?php
        $stmt = $conn->prepare("SELECT discount_description FROM discount");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row["discount_description"].'">'.$row['discount_description'].'</option>';
        }
        ?>
    </select> <br><br>
    <button type="submit" name="remove">Remove Discount</button>
</form>

    </section>
</body>
</html>
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $discount_description = $_POST['discount-description'];
    $category = $_POST['discount-category'];
    $discount_amount = $_POST['discount-amount'];

    // First, get the category ID
    $sqll = "SELECT category_id FROM category WHERE category_name=?";
    $stmt = $conn->prepare($sqll);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cat_id = $row['category_id'];

    // Insert the discount with the category ID
    $sql = "INSERT INTO discount (discount_description, amount, category_id) 
            VALUES (?,?,?)";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("sii", $discount_description, $discount_amount, $cat_id);
    if (!$stmt2->execute()) {
        die("Error : " . $conn->error);
    }
}
?>

