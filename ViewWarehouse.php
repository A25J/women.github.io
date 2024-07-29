
<?php
session_start();
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> View Warehouse</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('images/Model\ \(2\).jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            vertical-align: middle;
        }

        nav {
            display: flex;
            justify-content: flex-end;
            width: 100vw;
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
            color: #000;
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
            background: grey;
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

        .main-container {
            display: flex;
            margin-top: 60px;
            /* Adjusting for fixed navbar height */
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            justify-content: center;
            align-items: flex-start;
        }

        .left-side {
            flex: 1;
            max-width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            max-width: 100%;
            height: auto;
        }

        .right-side {
            flex: 2;
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid grey;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
            margin-left: 100px;
        }

        .warehouse-content {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 90%;
        }

        .warehouse-content p {
            margin: 10px 0;
            color: #333;
        }

        @media screen and (max-width: 768px) {
            .main-container {
                flex-direction: column;
                align-items: center;
            }

            .right-side {
                width: 90%;
                margin-left: 0;
            }
        }

        @media screen and (max-width: 480px) {
            .nav-bar {
                flex-direction: column;
                align-items: center;
            }

            .nav {
                padding: 10px 0;
            }

            .main-container {
                flex-direction: column;
                align-items: center;
            }

            .right-side {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav-container">
            <ul class="nav-bar">
                <li class="nav"><a href="adminhome.php" class="nav-links" id="home">Home</a></li>
                <li class="nav"><a href="ADManageCategory.php" class="nav-links" id="cart">Manage Categories</a></li>
                <li class="nav"><a href="ADAddDiscount.php" class="nav-links" id="support">Add Discount</a></li>
                <li class="nav"><a href="ADManageitems.php" class="nav-links" id="account">Manage Items</a></li>
                <li class="nav"><a href="ADManageEmployees.php" class="nav-links" id="account">Manage Employees</a></li>
                <li class="nav"><a href="ViewWarehouse.php" class="nav-links" id="login">View Warehouse</a></li>
                <li class="nav"><a href="logout.php" class="nav-links" id="account"><ion-icon name="exit-outline"></ion-icon></a></li>
            </ul>
        </div>
    </nav>

    <div class="main-container">
        <div class="left-side">
            <img src="images/logo.png" alt="Logo" class="logo">
        </div>
        <div class="right-side">
            <h2>Warehouse Content</h2>
            <div class="warehouse-content">
                <!-- Content related to the warehouse goes here -->
                <?php
                $stmt = $conn->prepare("SELECT * FROM warehouse");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<p> Product name:" . $row['product_name'] . "</p>";
                    echo "<p>Number of items: " . $row['nb_of_product'] . "</p>";
                    $st = $conn->prepare("SELECT category_name FROM category WHERE category_id = ?");
                    $st->bind_param("i", $row['category_id']);
                    $st->execute();
                    $res = $st->get_result();
                    $r = $res->fetch_assoc();
                    echo "<p> Category: " . $r['category_name'] . "</p>";
                    echo "<p> Date of last Shipment: " . $row['dateof_last_shipment'] . "</p>";
                    echo "<hr>";
                }
                ?>
                <!-- Add more items as needed -->
            </div>
        </div>
    </div>
</body>

</html>