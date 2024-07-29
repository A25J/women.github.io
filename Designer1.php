<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in ...'); window.history.back= 'Loginform.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <title>Choose Chat</title>
</head>

<body>
    <nav>
        <ul class="nav-bar">
            <li class="nav"><a href="Designer1.php" class="nav-links" id="account">Home</a></li>
            <li class="nav">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php" class="nav-links" id="login">Logout</a>';
                } else {
                    echo '<a href="Loginform.php" class="nav-links" id="login">Login</a>';
                }
                ?>
            </li>
            
            <li class="nav"><a href="desAccount.php" class="nav-links" id="account">Account</a></li>
        </ul>
    </nav> <br><br><br><br><br>

    <div class="container">
        <h1>Choose Chat</h1>
        <?php
        // Prepare the SQL query to get distinct customer IDs from the messages table
        $stmt = $conn->prepare("SELECT DISTINCT customer_id FROM messages");
        $stmt->execute();
        $result = $stmt->get_result();

        // Iterate through each customer ID found in the messages table
        while ($row = $result->fetch_assoc()) {
            $customer_id = $row['customer_id'];

            // Prepare the SQL query to get customer details
            $stmt2 = $conn->prepare("SELECT customer_username, customer_pic FROM customer WHERE customer_id = ?");
            $stmt2->bind_param("i", $customer_id);
            $stmt2->execute();
            $res2 = $stmt2->get_result();

            // Fetch and display customer details
            while ($row2 = $res2->fetch_assoc()) {
                $customer_username = htmlspecialchars($row2['customer_username']);
                $image_path = htmlspecialchars($row2['customer_pic']);
                echo "<a href='deschat.php?customer={$customer_id}' class = 'user-link'>
                    <div class='user'> 
                        <img src='cutomerimages/{$image_path}' alt='Customer Image'>
                        <pre>{$customer_username}</pre>
                    </div>
                  </a>";
            }
        }
        ?>
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

    .container {
        width: 70%;
        max-width: 1200px;
        margin: 40px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
        color: #444;
    }

    .user-link {
        text-decoration: none;
        color: inherit;
    }


    .user {
        display: flex;
        align-items: center;
        background-color: grey;
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user:hover {
        background-color: #eaeaea;
    }

    .user-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 15px;
    }

    .user-name {
        font-size: 1.2em;
        font-weight: bold;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    pre {
        margin: 10px;
        font-family: inherit;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .user img{
        height: 100px;
        width: 100px;
        border-radius: 50%;
    }
</style>