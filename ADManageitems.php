<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage items</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <link rel="stylesheet" href="ADMAanageItems.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>
<body>
    <?php
    include "conn.php";
    session_start();
    ?>
    <div class="nav-container">
<nav>
            <li class="nav"><a href="adminhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="ADManageCategory.php" class="nav-links" id="cart">Manage Categories</a></li>
            <li class="nav"><a href="ADAddDiscount.php" class="nav-links" id="support">Add Discount</ion-icon></a></li>
            <li class="nav"><a href="ADManageitems.php" class="nav-links" id="account">Manage Items</a></li>
            <li class="nav"><a href="ADManageEmployees.php" class="nav-links" id="account">Manage Employees </a></li>
            <li class="nav"><a href="ViewWarehouse.php" class="nav-links" id="login">View Warehouse</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="account"><ion-icon name="exit-outline"></ion-icon></a></li>
    </nav>
    </div>
    <section>
        <h1>Manage Items</h1>
        <h2>Add items to categories</h2>
        <form action="AddItems.php" method="post" enctype="multipart/form-data">
        <div class="inputbox">
            <ion-icon name="file-tray-full-outline"></ion-icon>
            <input type="text" required name="item-name">
            <label for="">Item Name</label>
            </div>
            <div class="inputbox">
            <ion-icon name="file-tray-full-outline"></ion-icon>
            <input type="text" required name="item_price">
            <label for="">Item price</label>
            </div>
            <div class="inputfile">
            <ion-icon name="image-outline"></ion-icon>
            <label for="uploadimg">Upload Image</label> 
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            </div>
            <p>Select category the item belongs to</p>
                <select name="categories" id="">
                    <option value="none">Choose Category</option>
                    <?php
                    $stmt = $conn->prepare("SELECT category_name FROM category");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row=$result->fetch_assoc()) {
                        echo "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                    }
                    ?>
                </select> <br>
                <div class="inputbox">
                <ion-icon name="file-tray-full-outline"></ion-icon>
                <input type="text" required name="item_brand">
                <label for="">Item brand</label>
                </div>
                <div class="inputbox">
                <ion-icon name="file-tray-full-outline"></ion-icon>
                <input type="text" required name="item_material">
                <label for="">Item material</label>
                </div>
                Is the brand boycott? 
                <input type="checkbox" name="boycott" id="boycott" value="1"> yes <br><br>
                <button type="submit" name="add-item">Add Item</button>
        </form>
    </section>
</body>
</html>
