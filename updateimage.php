<?php
session_start();
include 'conn.php';
$customer_id = $_SESSION['id'];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['image'])) {
    if ($_FILES["image"]["error"] === UPLOAD_ERR_NO_FILE) {
     echo "<script>alert('Image doesn't exist :/');</script>";
    }
    else {
     $filename = $_FILES["image"]["name"];
     $filesize = $_FILES["image"]["size"];
     $tempname = $_FILES["image"]["tmp_name"]; 
     
     $validImageExtensions = ["jpg", "jpeg", "png"];
     $imageExtension = pathinfo($filename, PATHINFO_EXTENSION);
     
     if (!in_array($imageExtension, $validImageExtensions)) {
         echo "<script>alert('Invalid file type. Please upload an image with a valid extension');</script>";
         } else if ($filesize > 2097152) { // File size is greater than 2MB (2048 KB).
             echo "<script>alert('File too large! Please keep files under 2 MB.');</script>";
         }
         else{
             $newImageName = uniqid() . '.' . $imageExtension;
             $uploadPath = "cutomerimages/" . $newImageName;
 
             if (move_uploaded_file($tempname, $uploadPath)) {
                 $customer_id = $_SESSION['id'];
 
                 // Insert new category
                 $stmt = $conn->prepare("UPDATE customer SET customer_pic = ? WHERE customer_id = ?");
                 $stmt->bind_param("si", $newImageName, $customer_id);
                 $stmt->execute();
 
                 if ($stmt->affected_rows > 0) {
                     echo "<script> alert('Profile picture has been uploaded successfully')</script>";
                     echo "<script>window.location.href= 'customerAccount.php';</script>";
                 } else {
                     die("Error in inserting category: " . $stmt->error);
                 }
             } else {
                 echo "<script>alert('Error uploading file.');</script>";
             }
         }
     }
 }
?>