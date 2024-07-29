<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="icon" type="image/png" href="/Women's Wear/images/logo.png">
    <link rel="stylesheet" href="Loginform.css">
    <?php
    include "conn.php";
    ?>
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

    <section>
        <form action="registercode.php" method="post" enctype="multipart/form-data">
            <h1>Sign up</h1>
            <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" required name="user">
            <label for="">Username</label>
            </div>

            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" required name="email">
                <label for="">Email</label>
            </div>
            <div class="inputbox">
                <ion-icon name="call-outline"></ion-icon>
                <input type="text" required name="phonenb">
                <label for="">Phone number</label>
            </div>

            <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" required name="pass">
            <label for="">Password</label>
            </div>
            <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" required name="confirmpass">
            <label for="">Confirm Password</label>
            </div>
            <button>Signup</button>
            
        </form>
    </section>
</body>
</html>