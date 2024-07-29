<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id'])) {
    echo "You must be logged in to send messages.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sending'])) {
    $designer_id = $_SESSION['id'];
    $customer_id = $_POST['customer_id'];
    $message = $_POST['chatting'];

    // Save the message to the database
    $stmt = $conn->prepare("INSERT INTO messages (customer_id, designer_id, `out-message`) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("error" . $conn->error);
    }
    $stmt->bind_param('iis', $customer_id, $designer_id, $message);
    $stmt->execute();

    // Fetch all messages again to display updated chat
    $sql = $conn->prepare("SELECT * from messages WHERE customer_id = ? AND designer_id = ?");
    $sql->bind_param('ii', $customer_id, $designer_id);
    $sql->execute();
    $result = $sql->get_result();
    while ($row = $result->fetch_assoc()) {
        echo '<div class="in-message">' . htmlspecialchars($row['in-message']) . '</div><br><br>';
        if (!empty($row['out-message'])) {
            echo '<div class="out-message">' . htmlspecialchars($row['out-message']) . '</div><br><br>';
        }
    }
}
