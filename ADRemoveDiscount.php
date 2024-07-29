<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove'])) {
    $discount_description = $_POST["remove-discount"];
    $stmt = $conn->prepare("DELETE FROM discount WHERE discount_description = ?");
    $stmt->bind_param("s", $discount_description);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Discount deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting discount, try again later.');</script>";
    }
    header('Location: ADAddDiscount.php');
    exit;
}
?>
