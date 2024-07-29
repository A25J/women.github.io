<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage category</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="ADManageCategory.css">
</head>
<body>
    <?php
    include "conn.php";
    ?>
<nav>
            <li class="nav"><a href="adminhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="ADManageCategory.php" class="nav-links" id="cart">Manage Categories</a></li>
            <li class="nav"><a href="ADAddDiscount.php" class="nav-links" id="support">Add Discount</ion-icon></a></li>
            <li class="nav"><a href="ADManageitems.php" class="nav-links" id="account">Manage Items</a></li>
            <li class="nav"><a href="ADManageEmployees.php" class="nav-links" id="account">Manage Employees </a></li>
            <li class="nav"><a href="ViewWarehouse.php" class="nav-links" id="login">View Warehouse</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="account"><ion-icon name="exit-outline"></ion-icon></a></li>
    </nav> <br><br><br>
 
    <section>
        <h1>Manage Category</h1>
        <h2>Add Categories</h2>
        <form action="ADAddCategory.php" method="post" enctype="multipart/form-data">
            <div class="inputbox">
            <ion-icon name="file-tray-full-outline"></ion-icon>
            <input type="text" required name="category-name">
            <label for="">Category Name</label>
            </div>
            <div class="inputfile">
            <ion-icon name="image-outline"></ion-icon>
            <label for="uploadimg">Upload Image</label> 
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit">Add Category</button>
            </form>
            <hr>
            <div class="remove">
                <h2>Remove Categories</h2>
                <form action="ADRemoveCategory.php" method="post">
                <p>Select category to be removed <ion-icon name="trash-outline"></ion-icon></p>
                <select name="categories" id="">
                    <option value="none">None</option>
                    <?php
                    $stmt = $conn->prepare("SELECT category_name FROM category");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row=$result->fetch_assoc()) {
                        echo "<option value='".$row['category_name']."'>".$row['category_name']."</option>";
                    }
                    ?>
                </select> <br>
                <input type="Submit" value="Remove Category">
            </div>
        </form>
    </section>
</body>
</html>

