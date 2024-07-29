<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
<?php
    session_start();
?>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('images/Model\ \(2\).jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
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

        /* Form styling */
        form {
            border: solid gainsboro 2px;
            background: transparent;
            backdrop-filter: blur(5px);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 270px;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-color: transparent;
            background-color: gainsboro;
            box-sizing: border-box;
        }
        h1{
            color: #fff;
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
    
    <form action="passwordReset.php" method="post">
        <h1>Forgot your password? Reset it here</h1>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="username">
        
        <label for="newpassword">New Password</label>
        <input type="password" name="newpassword" id="newpassword" placeholder="new password">
        
        <label for="confirmpass">Confirm password</label>
        <input type="password" name="confirmpass" id="confirmpass" placeholder="confirm password">
        <br>
        <button type="submit" name="submit">Reset Password</button>
        <br><br><br><br>
    </form>
</body>
</html>

<?php
    include "conn.php";
    require "mailerscript.php";
    use PHPMailer\PHPMailer\PHPMailer;
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])){
        $username = $_POST['username'];
        $newpassword = $_POST['newpassword'];
        $confirmpass = $_POST['confirmpass'];
        if (strlen($_POST['newpassword']) < 8) {
            echo "<script>alert('Password must be at least 8 characters long!')</script>";
            echo "<meta http-equiv='refresh' content='0;url=passwordReset.php?err=passwordshort'>";  
            exit;
        }
        if (!preg_match("/[a-z]/i", $_POST['newpassword'])) {
            echo "<script>alert('Password should contain at least one letter!')</script>";
            echo "<meta http-equiv='refresh' content='0;url=passwordReset.php?err=nolowercase'>"; 
            exit;
        }
        if (!preg_match("/[0-9]/", $_POST['newpassword'])) {
            echo "<script>alert('Password should contain at least one number!')</script>";
            header("Location: passwordReset.php?err=nonumber"); 
            exit;
        }
        if ($_POST['newpassword'] != $_POST['confirmpass']) {
            echo "<script>alert('Passwords do not match!')</script>";
           // echo "<meta http-equiv='refresh' content='0;url=passwordReset.php?err=notmatched'>"; 
            exit;
        }

        $stmt1 = $conn->prepare("SELECT * FROM customer WHERE customer_username = ?");
        $stmt2 = $conn->prepare("SELECT * FROM admin WHERE admin_username = ?");
        $stmt3 = $conn->prepare("SELECT * FROM fashion_designer WHERE designer_username = ?");
        $stmt4 = $conn->prepare("SELECT * FROM warehouse_specialist WHERE spec_username = ?");

        $stmt1->bind_param("s", $username);
        $stmt2->bind_param("s", $username);
        $stmt3->bind_param("s", $username);
        $stmt4->bind_param("s", $username);

        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();

        $result1 = $stmt1->get_result();
        $result2 = $stmt2->get_result();
        $result3 = $stmt3->get_result();
        $result4 = $stmt4->get_result();

        if($result1->num_rows > 0){
            //the user is a customer
            $row = $result1->fetch_assoc();
            $stmt5 = $conn->prepare("UPDATE customer SET customer_password = ? WHERE customer_username = ?");
            $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt5->bind_param("ss", $hashed, $username);
            if($stmt5->execute()){
                $sm = $conn->prepare("SELECT customer_email FROM customer WHERE customer_username = ?");
                $sm->bind_param("s", $username);
                $sm->execute();
                $result = $sm->get_result();
                $row1 = $result->fetch_assoc();
                sendEmail($row1['customer_email'], "Your new Password", "Hello $username, <br><br> YOur new Password is: $newpassword");
                echo "<script>alert('Password is changed successfully'); window.href.location = 'Loginform.php'</script>";
            }   
            else{
                echo "<script>alert('Cannot Change password, Please try again later'); window.href.location = 'passwordReset.php?err=notchanged'</script>";
            }
        }
        exit;

        if($result2->num_rows > 0){
            //the user is an admin
            $row = $result2->fetch_assoc();
            $stmt5 = $conn->prepare("UPDATE admin SET admin_password = ? WHERE admin_username = ?");
            $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt5->bind_param("ss", $hashed, $username);
            if($stmt5->execute()){
                $sm = $conn->prepare("SELECT admin_email FROM admin WHERE admin_username = ?");
                $sm->bind_param("s", $username);
                $sm->execute();
                $result = $sm->get_result();
                $row2 = $result->fetch_assoc();
                sendEmail($row2['admin_email'], "Your new Password", "Hello $username, <br><br> YOur new Password is: $newpassword");
                echo "<script>alert('Password is changed successfully'); window.href.location = 'Loginform.php'</script>";

            }
            else{
                echo "<script>alert('Cannot Change password, Please try again later'); window.href.location = 'passwordReset.php?err=notchanged'</script>";
            }

        }
        exit;
        if($result3->num_rows > 0){
            //the user is a designer
            $row = $result3->fetch_assoc();
            $stmt5 = $conn->prepare("UPDATE designer SET designer_password = ? WHERE designer_username = ?");
            $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt5->bind_param("ss", $hashed, $username);
            if($stmt5->execute()){
                $sm = $conn->prepare("SELECT designer_email FROM designer WHERE designer_username = ?");
                $sm->bind_param("s", $username);
                $sm->execute();
                $result = $sm->get_result();
                $row3 = $result->fetch_assoc();
                sendEmail($row3['designer_email'], "Your new Password", "Hello $username, <br><br> YOur new Password is $newpassword");
                echo "<script>alert('Password is changed successfully'); window.href.location = 'Loginform.php'</script>";
                }
            else{
                echo "<script>alert('Cannot Change password, Please try again later'); window.href.location = 'passwordReset.php?err=notchanged'</script>";

            }
        }
        exit;
        if($result4->num_rows > 0){
            //the user is a spec
            $row = $result4->fetch_assoc();
            $stmt5 = $conn->prepare("UPDATE spec SET spec_password = ? WHERE spec_username = ?");
            $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt5->bind_param("ss", $hashed, $username);
            if($stmt5->execute()){
                $sm = $conn->prepare("SELECT spec_email FROM spec WHERE spec_username = ?");
                $sm->bind_param("s", $username);
                $sm->execute();
                $result = $sm->get_result();
                $row4 = $result->fetch_assoc();
                sendEmail($row4['spec_email'], "Your new Password", "Hello $username, <br><br> YOur new Password is $newpassword");
                echo "<script>alert('Password is changed successfully'); window.href.location = 'Loginform.php'</script>";
                }
                else{
                    echo "<script>alert('Cannot Change password, Please try again later'); window.href.location = 'passwordReset.php?err=notchanged'</script>";

                }   
        }
        
        exit;
    }
?>
