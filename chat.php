<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['id'])) {
    echo "<script>'alert(You must be logged in...'); window.history.back = 'Loginform.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communicate with Customer <?php echo $_GET['customer']; ?></title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
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
    <br><br><br><br><br>

    <div class="container">
        <div class="header">
            <?php

            // Ensure the user is logged in and customer_id is available in the session

            $customer_id = $_GET['customer'];

            // Prepare the SQL statement to fetch the customer image
            $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
            if ($stmt === false) {
                error_log('mysqli statement prepare error: ' . htmlspecialchars($conn->error));
                echo "<script>alert('Database error: Failed to prepare statement.'); window.history.back();</script>";
                exit();
            }

            // Bind the customer ID parameter
            $stmt->bind_param("i", $customer_id);

            // Execute the statement
            if ($stmt->execute()) {
                $res = $stmt->get_result();

                // Fetch the result and display the image
                if ($row = $res->fetch_assoc()) {
                    $image_path = $row['customer_pic'];
                    echo "<img src='cutomerimages/$image_path' alt='Customer Image'>";
                    echo "<pre calss='name'>" . $row['customer_username'] . "</pre>";
                    echo "<pre class='status'> " . $row['status'] . "</pre>  ";
                }
            } else {
                error_log('mysqli statement execute error: ' . htmlspecialchars($stmt->error));
                echo "<script>alert('Database error: Failed to execute statement.'); window.history.back();</script>";
            }

            // Close the statement
            $stmt->close();

            ?>
        </div>
        <div class="content">
            <?php
            $stmt1 = $conn->prepare("SELECT * from messages WHERE customer_id = ?");
            $stmt1->bind_param("i", $customer_id);
            $stmt1->execute();
            $res1 = $stmt1->get_result();
            while ($row1 = $res1->fetch_assoc()) {
                while ($row1['out-message'] === null)
                    echo "<pre>{$row1['in-message']}</pre>";
                while ($row1['in-message'] === null)
                    echo "<pre>{$row1['out-message']}";
            }
            ?>

        </div>
        <div class="chat-text">
            <form action="" method="post">
                <textarea name="chat" id="" placeholder="Enter your message here"></textarea>
                <button type="submit" name="send-chat">send</button>
            </form>
        </div>
    </div>
</body>

</html>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        background-repeat: no-repeat;
        background-size: cover;
        vertical-align: middle;
        overflow-x: hidden;
        background-attachment: fixed;
        width: 100vw;
    }

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

    }

    .container {
        align-items: center;
        justify-content: center;
        background: #000;
        align-items: center;
        height: 80vh;
        margin-left: 20vw;
        margin-right: 20vw;
        border-radius: 20px;
    }

    .container .header {
        display: flex;
        border-bottom: grey solid 1px;
        box-shadow: gray;

    }

    .container .header img {
        height: 50px;
        width: 50px;
        float: left;
        justify-content: flex-start;
        margin-left: 30px;
        margin-top: 20px;
        border-radius: 50%;

    }

    .container .header pre {
        color: white;
        font-size: 20px;
        font-weight: 100;
        margin-left: 20px;
    }

    .container .header .status {
        color: green;
        font-size: 10px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-left: 5px;
    }

    .chat-text textarea {
        background-color: gainsboro;
        bottom: 0;
        border-radius: 20px;
    }
</style>