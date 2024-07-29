<?php
session_start(); // Start the session at the beginning of the script

// Checking connection
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["user"];
    $password = $_POST["pass"];

    // Prepare the SQL statement to fetch the user based on username
    $stmt = $conn->prepare("SELECT customer_id, customer_username, customer_password, verified FROM customer WHERE customer_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $user = $result->fetch_assoc();

        if ($user['verified'] == 1 ) {
            if (password_verify($password, $user['customer_password'])) {
                // Password is correct, redirect to home page and store username in session
                $_SESSION['username'] = $username;
                $_SESSION['logged'] = 1;
                $_SESSION['id'] = $user['customer_id'];
                $id = $_SESSION['id'];
                $ss = $conn->prepare("UPDATE customer SET status = 'Active' WHERE customer_username = ?");
                $ss->bind_param("i", $id);
                $ss->execute();

                echo "<script>alert('Welcome back! $username'); window.location.href = 'customerhome.php';</script>";
                exit(); // Prevent further execution
            } else {
                // Password is incorrect
                echo "<script>alert('Incorrect password!'); window.history.back = 'Loginform.php';</script>";
                exit();
            }
        } else {
            // Account is not verified
            echo "<script>alert('You haven\\'t verified your account yet, please verify and try again.'); window.location.href = 'emailverify.php';</script>";
            exit();
        }
    }

    $stmt->close();

    // Check for admin login
    $stmt = $conn->prepare("SELECT admin_id, admin_username, admin_password FROM `admin` WHERE admin_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admin found, verify password
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['admin_password'])) {
            // Password is correct, redirect to admin home page
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $admin['admin_id'];
            
            echo "<script>window.location.href = 'adminhome.php'; alert('Welcome back, $username!');</script>";
            exit();
        }
    }

    $stmt->close();

    // Check for designer login
    $stmt = $conn->prepare("SELECT designer_id, designer_username, designer_password FROM fashion_designer WHERE designer_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Designer found, verify password
        $designer = $result->fetch_assoc();
        if (password_verify($password, $designer['designer_password'])) {
            // Password is correct, redirect to designer page
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $designer['designer_id'];
            echo "<script>window.location.href = 'Designer1.php'; alert('Welcome back, $username!');</script>";
            exit();
        }
    }

    $stmt->close();

    // Check for warehouse specialist login
    $stmt = $conn->prepare("SELECT spec_id, spec_username, spec_password FROM warehouse_specialist WHERE spec_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Warehouse specialist found, verify password
        $spec = $result->fetch_assoc();
        if (password_verify($password, $spec['spec_password'])) {
            // Password is correct, redirect to warehouse specialist page
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $spec['spec_id'];
            echo "<script>window.location.href = 'warehouseSpecialist.php'; alert('Welcome back, $username!');</script>";
            exit();
        }
    }

    $stmt->close();

    // User not found
    echo "<script>alert('Username not found, please check credentials or SIGNUP!'); window.location.href='registerform.php';</script>";
    exit();
}
?>
