<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $username = $_POST['username']; // Assuming you have a username field in your form
    // getting designers usernames
    $stmtdes = $conn->prepare("SELECT * FROM fashion_designer WHERE designer_username = ?");
    $stmtdes->bind_param("s", $username);
    $stmtdes->execute();
    $resdes = $stmtdes->get_result();
    $desrows = $resdes->num_rows;
    
    //getting warehouse specialists usernames
    $stmtspec = $conn->prepare("SELECT * FROM warehouse_specialist WHERE spec_username = ?");
    $stmtspec->bind_param("s", $username);
    $stmtspec->execute();
    $resspec = $stmtspec->get_result();
    $specrows = $resspec->num_rows;

    $dbspec=mysqli_query($conn,"SELECT * from warehouse_specialist where spec_username='$username'");
    
    if ($desrows > 0) {
        $sql = "DELETE FROM fashion_designer WHERE designer_username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Designer is removed successfully'); window.location.href = 'ADManageEmployees.php'</script>";
    } elseif ($specrows > 0) {
        $sql = "DELETE FROM warehouse_specialist WHERE spec_username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Warehouse Specialist is removed successfully'); window.location.href = 'ADManageEmployees.php'</script>";
    } else {
        echo "Invalid remove option";
    }
}
?>
