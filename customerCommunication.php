<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['id'])) {
    echo "<script>alert('You must be logged in...'); window.location.href = 'Loginform.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communicate with the Designer</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <link rel="stylesheet" href="styles.css">
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

    <div class="content-container">
        <div class="container">
            <section>
                <h1>Select a Designer to Communicate With</h1>
                <?php
                $stm = $conn->prepare("SELECT * FROM fashion_designer");
                $stm->execute();
                $res = $stm->get_result();
                while ($row = $res->fetch_assoc()) {
                    echo '<div class="designer"><a href="customerChat.php?designer=' . $row['designer_id'] . '"><img src="designerimage/' . $row['designer_image'] . '" alt="designer" class="designer-img"> <pre>' . $row['designer_username'] . '</pre></a></div>';
                }
                ?>
            </section>
        </div>
    </div>
</body>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        overflow-x: hidden;
        background-attachment: fixed;
        min-height: 100vh;
    }

    nav{
    
    position: relative;
    flex-wrap: wrap;
    width: 100vw;
    margin-right: 5px;
    float: right;
    
}


.nav-bar{
    position: relative;
    list-style: none;
    display: table;
    text-align: center;
    float: right;
}

.nav{
    
    display: table-cell;
    position: sticky;
    padding: 15px 0;
    font-family: "Arial", sans-serif;
    
}

.nav-links{
    color: black;
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
    background: black;
    transition: width 0.5s ease 0s, left 0.5s ease 0s;
    width: 0%;
    margin: 4px;
}

.nav-links:hover::after{
    width: 100%;
    left: 0%;
    background-color: rgb(88, 154, 173);
}


    .content-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
        /* Adjusting for fixed navbar height */
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 80%;
        max-width: 800px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    section {
        width: 100%;
    }

    section h1 {
        color: rgba(0, 0, 0, 0.6);
        text-align: center;
        margin-bottom: 20px;
    }

    .designer {
        margin: 20px 0;
        padding: 20px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .designer img {
        height: 60px;
        width: 60px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .designer a {
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
    }

    .designer pre {
        margin: 0;
        font-size: 15px;
    }

    .logo {
        position: fixed;
        bottom: 10px;
        left: 10px;
    }

    @media screen and (max-width: 480px) {
        .nav-bar {
            flex-direction: column;
            align-items: center;
        }

        .nav {
            padding: 10px 0;
        }

        .container {
            width: 90%;
            padding: 10px;
        }

        .designer {
            flex-direction: column;
            align-items: flex-start;
        }

        .designer img {
            margin-bottom: 10px;
        }
    }
</style>

</html>