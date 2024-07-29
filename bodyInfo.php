<?php
session_start();
include 'conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['comm'])) {
    // Validate and sanitize inputs
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bodyshape = $_POST['body-shape'];
    $skincolor = $_POST['skin-color'];
    $skintone = $_POST['skin-tone'];

    if (!$height || !$weight || !$bodyshape || !$skincolor || !$skintone) {
        echo "<script>alert('Invalid input detected. Please check your inputs and try again.'); window.history.back();</script>";
        exit();
    }

    $customer_id = $_SESSION['id'];

    if (!$customer_id) {
        echo "<script>alert('Session error: Customer ID is missing.'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO body_information (customer_id, height, `weight`, body_shape, skin_color, skin_tone) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt->bind_param("iiisss", $customer_id, $height, $weight, $bodyshape, $skincolor, $skintone)) {
        error_log('mysqli statement bind_param error: ' . htmlspecialchars($stmt->error));
        echo "<script>alert('Database error: Failed to bind parameters.'); window.history.back();</script>";
        exit();
    }
    $stmt->execute();
    $nb = $stmt->affected_rows;
    if ($nb > 0) {
        $_SESSION['bodyinfo'] = true;
        echo "<script>alert('Your info is saved, you can edit later...'); window.location.href='customerCommunication.php';</script>";
    } else {
        error_log('mysqli statement execute error: ' . htmlspecialchars($stmt->error));
        echo "<script>alert('Database error: Failed to save information.'); window.history.back();</script>";
    }

    $stmt->close();
}
