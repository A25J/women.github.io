<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['Employee-email']) || !filter_var($_POST['Employee-email'], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!')</script>";
        echo "<script>window.location.href = 'ADManageEmployees.php';</script>";
        exit();
    }
    if (strlen($_POST['Employee-password']) < 8) {
        echo "<script>alert('Password must be at least 8 characters long!')</script>";
        echo "<script>window.location.href = 'ADManageEmployees.php?err=passwordshort';</script>";
        exit();
    }
    if (!preg_match("/[a-z]/i", $_POST['Employee-password'])) {
        echo "<script>alert('Password should contain at least one letter!')</script>";
        echo "<script>window.location.href = 'ADManageEmployees.php?err=nolowercase';</script>";
        exit();
    }
    if (!preg_match("/[0-9]/", $_POST['Employee-password'])) {
        echo "<script>alert('Password should contain at least one number!')</script>";
        echo "<script>window.location.href = 'ADManageEmployees.php?err=nonumber';</script>";
        exit();
    }

    $password_hash = password_hash($_POST['Employee-password'], PASSWORD_DEFAULT);
    $username = $_POST['Employee-username'];
    $phonenb = $_POST['Employee-phonenb'];
    $email = $_POST['Employee-email'];
    $contracttype = $_POST['contract-type'];
    $employeerole = $_POST['employee-role'];

    if ($employeerole === 'specialist') {
        $sql1 = "SELECT * FROM warehouse_specialist WHERE spec_username = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $username);
        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            echo '<script>alert("Username already exists!"); window.location.href = "ADManageEmployees.php";</script>';
        } else {
            $sql = "INSERT INTO warehouse_specialist (spec_username, spec_password, spec_email, spec_phone, hiredbyadmin, contract_type)
                    VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssiis", $username, $password_hash, $email, $phonenb, $_SESSION['id'], $contracttype);
            $stmt->execute();
            echo "<script>alert('Welcome sir'); window.location.href= 'adminhome.php';</script>";
        }
    }

    if ($employeerole === "Admin") {
        $sql2 = "SELECT * FROM admin WHERE admin_username = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            echo "<script>alert('Username already exists'); window.location.href = 'ADManageEmployees.php?error=Username already exists';</script>";
            exit();
        } else {
            $sql = "INSERT INTO admin (admin_username, admin_password, admin_email, admin_phone)
                VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $password_hash, $email, $phonenb);
            $stmt->execute();
            echo "<script>alert('Admin is hired successfully'); window.location.href = 'ADManageEmployees.php';</script>";
        }
    }
    if($employeerole === "designer"){
        $sql_check = "SELECT * FROM fashion_designer WHERE designer_username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
    
        if($result_check->num_rows === 0){
            $sql = "INSERT INTO fashion_designer (designer_username, designer_password, designer_email, designer_phone, designer_image, hiredbyadmin, contract_type, hiring_date)
                    VALUES (?, ?, ?, ?, DEFAULT, ?, ?, DEFAULT)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssiis", $username, $password_hash, $email, $phonenb, $_SESSION['id'], $contracttype);
            $stmt->execute();
            echo "<script>alert('Fashion designer is hired successfully!'); window.location.href = 'ADManageEmployees.php';</script>";
        } else {
            echo "<script>alert('Username already exists!'); window.location.href = 'ADManageEmployees.php';</script>";
        }
    }    
}
?>
