<?php
include "conn.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url('images/Model\ \(2\).jpeg');
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        nav {
            display: flex;
            margin-right: 5px;
            width: 100%;
            border-radius: 5px;
            border-color: beige;
            position: absolute;
            top: 0;
            padding: 10px; /* Add some padding */
        }

        .nav-bar {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Adjusted alignment */
            width: 100%; /* Take full width */
        }

        .nav {
            padding: 15px 20px;
            font-family: "Arial", sans-serif;
        }

        .nav-links {
            color: #000;
            text-decoration: none;
            position: relative;
            transition: color 0.3s;
            padding: 5px;
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
            bottom: -5px;
        }

        .nav-links:hover::after {
            width: 100%;
            left: 0%;
            background-color: rgb(88, 154, 173);
        }

        form {
            background-color: transparent;
            backdrop-filter: blur(5px);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
            border: solid gainsboro 2px;

        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: rgb(88, 154, 173);
            text-shadow: #000;
            
        }

        .digit-input {
            width: 40px;
            height: 40px;
            margin: 5px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .digit-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        button{
            width: 270px;
            height: 40px;
            border-radius: 40px;
            background-color: rgba(255,255,255,1);
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.4s ease;
        }

        button:hover{
            background-color:gainsboro;
            color: #000;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.digit-input').on('input', function() {
                const $this = $(this);
                const value = $this.val();
                if (value.length === 1) {
                    $this.next('.digit-input').focus();
                }
            });

            $('.digit-input').on('keydown', function(e) {
                const $this = $(this);
                if (e.key === 'Backspace' && !$this.val()) {
                    $this.prev('.digit-input').focus();
                }
            });
        });
    </script>
</head>
<body>
    <nav>
    <ul class="nav-bar">
            <li class="nav"><a href="customerhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="#" class="nav-links" id="cart">Cart</a></li>
            <li class="nav"><a href="#" class="nav-links" id="support">Get Support</a></li>
            <li class="nav"><a href="#" class="nav-links" id="track">Track order</a></li>
            <li class="nav"><a href="Loginform.php" class="nav-links" id="login">Login</a></li>
            <li class="nav"><a href="#" class="nav-links" id="account">Account</a></li>
         
        </ul>
    </nav> 
    <form action="emailverify.php" method="post">
        <h1>Enter your verification Code Sent to your email</h1>
        <br><br>
        <input type="text" maxlength="1" name="value1" class="digit-input">
        <input type="text" maxlength="1" name="value2" class="digit-input">
        <input type="text" maxlength="1" name="value3" class="digit-input">
        <input type="text" maxlength="1" name="value4" class="digit-input">
        <input type="text" maxlength="1" name="value5" class="digit-input">
        <input type="text" maxlength="1" name="value6" class="digit-input"><br><br><br>
        <button>Verify</button>
    </form>

    <?php
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $value1 = $_POST['value1'];
        $value2 = $_POST['value2'];
        $value3 = $_POST['value3'];
        $value4 = $_POST['value4'];
        $value5 = $_POST['value5'];
        $value6 = $_POST['value6'];

        $code = $value1 . $value2 . $value3 . $value4 . $value5 . $value6;
        $codeint = (int)$code;
        $stmt = $conn->prepare("SELECT verification_code FROM customer WHERE customer_id = ?");
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($codeint === (int)$row['verification_code']){
            $s = $conn->prepare("UPDATE customer set verified = '1' WHERE customer_id = ? ");
            $s->bind_param('i', $_SESSION['id']);
            $s->execute();

            echo "<script>alert('Email is verified! Welcome to our Website'); window.location.href = 'Loginform.php';</script>";
        } 
        /* else {
            echo "<script>alert('Email is not verified! Check your email and try again'); window.location.href = 'registerform.php';</script>";

        }*/
        print_r($_SESSION);
    } 
    
    ?>
</body>
</html>
