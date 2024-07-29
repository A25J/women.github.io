<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <link rel="stylesheet" href="ADManageEmployess.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <?php
    include "conn.php";
    ?>
</head>
<body>
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
        <h1>Manage Employees</h1>
        <form action="ADAddEmployees.php" method="post">
            <div>
            <h2>Add Employee</h2>
             <div class="inputbox">
                <ion-icon name="person-outline"></ion-icon>
                <input type="text" required name="Employee-username">
                <label for="">Employee username</label>
             </div>
             <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" required name="Employee-password">
                <label for="">Employee password</label>
             </div>
             <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" required name="Employee-email">
                <label for="">Employee email</label>
             </div>
             <div class="inputbox">
                <ion-icon name="call-outline"></ion-icon>
                <input type="text" required name="Employee-phonenb">
                <label for="">Employee phone number</label>
             </div>
             <select name="contract-type" id="">
                <option value="none" selected>Choose type</option>
                <option value="part-time-Remote">Part-time Remote</option>
                <option value="part-time-OnSite">Part-time on-Site</option>
                <option value="full-time-Remote">Full-time Remote</option>
                <option value="part-time-OnSite">Full-time on-Site</option>
             </select>
             <select name="employee-role" id="">
                <option value="none">Choose Role</option>
                <option value="Admin">Admin</option>
                <option value="designer">Fashion Designer</option>
                <option value="specialist">Warehouse specialist</option>
             </select>
             <button>Hire Employee</button>
        </form>
        </div>
        <hr>
        <form action="ADRemoveEmployees.php" method="post">
    <h2>Fire an Employee</h2>
   
    <select name="username" id="remove" >
        <option value="none">Choose Employee</option>
        <optgroup label="Fashion Designer">
            <?php
            $stmt = $conn->prepare("SELECT designer_username FROM fashion_designer");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['designer_username']."'>" . $row['designer_username'] . "</option>";
            }
            ?>
        </optgroup>
        <optgroup label="Warehouse Specialist">
            <?php
            $stmt2 = $conn->prepare("SELECT spec_username FROM warehouse_specialist");
            $stmt2->execute();
            $res = $stmt2->get_result();
            while ($rows = $res->fetch_assoc()) {
                echo "<option value='".$rows['spec_username']."'>" . $rows['spec_username'] . "</option>";
            }
            ?>
        </optgroup>
    </select>
    <button type="submit" name="submit">Fire Employee</button>
</form>


    </section>
</body>
</html>
