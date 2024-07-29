<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <link rel="stylesheet" href="Loginform.css">
</head>
<?php
    include "conn.php";
    ?>
<body>
<nav>
        <ul class="nav-bar">
            <li class="nav"><a href="customerhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="#" class="nav-links" id="cart">Cart</a></li>
            <li class="nav"><a href="#" class="nav-links" id="support">Get Support</a></li>
            <li class="nav"><a href="#" class="nav-links" id="track">Track order</a></li>
            <li class="nav"><a href="login1.php" class="nav-links" id="login">Login</a></li>
            <li class="nav"><a href="#" class="nav-links" id="account">Account</a></li>
        </ul>
    </nav>

    <section>
        <form action="login.php" method="post">
            <h1>Login</h1>
            <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" required name="user">
            <label for="">Username</label>
            </div>
            <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" required name="pass">
            <label for="">Password</label>
            </div>
            <div class="forget">
            <a href="passwordReset.php">Forget password</a>
            </div>
            <button>Login</button>
            <div class="register">
                <p>Don't have an account? <a href="registerform.php">Register</a></p>
            </div>
        </form>
    </section>
</body>
</html>

