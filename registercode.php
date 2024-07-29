<?php

use PHPMailer\PHPMailer\PHPMailer;

include "conn.php";
include "mailerscript.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function generateRandomCode($length = 6) {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= random_int(0, 9);
        }
        return $code;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!')</script>";
        echo "<meta http-equiv='refresh' content='0;url=registerform.php'>";  // back to register page
        exit;
    }
    if (strlen($_POST['pass']) < 8) {
        echo "<script>alert('Password must be at least 8 characters long!')</script>";
        echo "<meta http-equiv='refresh' content='0;url=registerform.php'>";  
        exit;
    }
    if (!preg_match("/[a-z]/i", $_POST['pass'])) {
        echo "<script>alert('Password should contain at least one letter!')</script>";
        echo "<meta http-equiv='refresh' content='0;url=registerform.php'>"; 
        exit;
    }
    if (!preg_match("/[0-9]/", $_POST['pass'])) {
        echo "<script>alert('Password should contain at least one number!')</script>";
        header("Location: register.php?err=nonumber"); 
        exit;
    }
    if ($_POST['pass'] != $_POST['confirmpass']) {
        echo "<script>alert('Passwords do not match!')</script>";
        echo "<meta http-equiv='refresh' content='0;url=registerform.php'>"; 
        exit;
    }

    $password_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $user = $_POST['user'];
    $asql = "SELECT * FROM customer WHERE customer_username = ?";
    $stmt1 = $conn->prepare($asql);
    $stmt1->bind_param("s", $user);
    $stmt1->execute();
    $aresult = $stmt1->get_result();

    if (!$aresult) {
        die("Error in querying database: " . $conn->error);
    }

    $numrows = $aresult->num_rows;

    if ($numrows > 0) {
        echo "<script>alert('Username already exists! Please try another username.')</script>";
        echo "<meta http-equiv='refresh' content='0;url=register.php?err=userexists'>";
    } else {
        $verificationcode = generateRandomCode();

        $sql = "INSERT INTO customer (customer_username, customer_password, customer_email, customer_phone, customer_pic, verification_code)
                VALUES(?, ?, ?, ?, Default, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL Error! " . $conn->error);
        }

        $stmt->bind_param("sssii", 
                          $_POST['user'], 
                          $password_hash, 
                          $_POST['email'], 
                          $_POST['phonenb'], 
                          $verificationcode);

        $stmt->execute();
        $stmt->close();

        $message = "Hello \n\n Your verification code for Women's Wear is " . $verificationcode;
        $stmt = $conn->prepare("SELECT customer_id FROM customer WHERE customer_username = ?");
        $stmt->bind_param("s", $_POST['user']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $_SESSION['id'] = $row['customer_id'];
        }
        $stmt->close();
        sendEmail($_POST['email'], "Your verification code", $message);
        echo "<script>alert('Please verify your account'); window.location.href = 'emailverify.php';</script>";
    }
}
?>
