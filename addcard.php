<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cardnb = $_POST['cardNumber'];
    $holdername = $_POST['cardHolderName'];
    $expirymonth = $_POST['month'];
    $expiryyear = $_POST['year'];
    $cvv = $_POST['cvv'];
    $customer_id = $_SESSION['id'];
    $expiryDate = $expirymonth . "/" . $expiryyear;

    // Validate inputs
    if (empty($cardnb) || empty($holdername) || empty($expirymonth) || empty($expiryyear) || empty($cvv)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Check if the card already exists
    $sql = "SELECT * FROM `card_info` WHERE customer_id = ? AND card_nb = ? AND name_holder = ? AND expiration_date = ? AND cvv = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $customer_id, $cardnb, $holdername, $expiryDate, $cvv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You already have this card!";
    } else {
        // Insert the new card
        $stmt1 = $conn->prepare("INSERT INTO card_info (card_nb, name_holder, expiration_date, cvv, customer_id) VALUES (?, ?, ?, ?, ?)");
        $stmt1->bind_param("issii", $cardnb, $holdername, $expiryDate, $cvv, $customer_id);

        if ($stmt1->execute()) {
            echo "success";
        } else {
            echo "Failed to add card. Please try again.";
        }
    }
}
?>
