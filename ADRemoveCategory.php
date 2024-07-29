<?php
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category = $_POST["categories"];
    $stmt = $conn->prepare("DELETE FROM category WHERE category_name= ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    
    if ($stmt === false) {
        echo "<script>alert('Error deleting category, try again later.');</script>";
    } else {
        echo "<script>alert('Category deleted successfully!');</script>";
        header('Location: ADManageCategory.php');
        exit; 
    }
}
?>
