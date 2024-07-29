<?php
include "conn.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add-item'])) {

    if ($_FILES["image"]["error"] === UPLOAD_ERR_NO_FILE) {
        echo "<script>alert('Image doesn\'t exist :/');</script>";
    } else {
        // Checks whether the file upload was successful
        $filename = $_FILES["image"]["name"];
        $filesize = $_FILES["image"]["size"];
        $tempname = $_FILES["image"]["tmp_name"];

        $validImageExtensions = ["jpg", "jpeg", "png"];
        $imageExtension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($imageExtension, $validImageExtensions)) {
            echo "<script>alert('Invalid file type. Please upload an image with a valid extension');</script>";
        } else if ($filesize > 2097152) { // File size is greater than 2MB (2048 KB).
            echo "<script>alert('File too large! Please keep files under 2 MB.');</script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadPath = "images/products/" . $newImageName;

            if (move_uploaded_file($tempname, $uploadPath)) {
                $name = $_POST['item-name'];
                $price = $_POST['item_price'];
                $category = $_POST['categories'];
                $brand = $_POST['item_brand'];
                $material = $_POST['item_material'];
                $boycott = isset($_POST['boycott']) ? 1 : 0; // Check if checkbox is checked

                $stmt = $conn->prepare("SELECT category_id FROM category WHERE category_name = ?");
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result = $stmt->get_result();
                $catId = $result->fetch_assoc();
                $categId = $catId['category_id'];
                $stmt->close();

                $sql = "INSERT INTO product (product_name, product_image, unit_price, category_id)
                        VALUES (?,?,?,?)";
                $stmt1 = $conn->prepare($sql);
                $stmt1->bind_param("ssii", $name, $newImageName,  $price, $categId);
                $stmt1->execute();

                if ($stmt1->affected_rows > 0) {
                    $stmt2 = $conn->prepare("SELECT product_id FROM product WHERE product_name = ?");
                    $stmt2->bind_param("s", $name);
                    $stmt2->execute();
                    $proId = $stmt2->get_result();
                    $row = $proId->fetch_assoc();
                    $prodId = $row["product_id"];

                    $stmt2->close();

                    $stmt3 = $conn->prepare("INSERT INTO specification (brand, material, boycott, product_id)
                            VALUES (?,?,?,?)");
                    $stmt3->bind_param("ssii", $brand, $material, $boycott, $prodId);
                    $stmt3->execute();

                    if ($stmt3->affected_rows > 0) {
                        echo "<script>alert('Item added successfully'); window.location.href='ADManageitems.php'</script>";
                    } else {
                        die("Error in inserting item: " . $stmt3->error);
                    }
                } else {
                    die("Error in inserting item: " . $stmt1->error);
                }
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        }
    }
}
?>