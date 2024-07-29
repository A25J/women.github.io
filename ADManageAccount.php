<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
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
    </nav>
</body>
</html>
<style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-image: url('images/Model\ \(2\).jpeg');
    background-repeat: no-repeat;
    background-size:cover;
    vertical-align: middle;
}

nav{
    display: flex;
    margin-right: 5px;
    float: right;
    align-items: center;
    justify-content: space-between;
}

.nav-bar{
    list-style: none;
    display: table;
    text-align: center;
}

.nav{
    display: table-cell;
    position: relative;
    padding: 15px 0;
    font-family: "Arial", sans-serif;

}

.nav-links{
    color: #000;
    text-decoration: none;
    display: inline-block;
    padding: 15px 20px;
    position: relative;

}

.nav-links::after{
    content: "";
    background: none repeat scroll 0 0 transparent;
    display: block;
    height: 4px;
    left: 50%;
    position: absolute;
    background: grey;
    transition: width 0.5s ease 0s, left 0.5s ease 0s;
    width: 0%;
    margin: 4px;
}

.nav-links:hover::after{
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
</style>