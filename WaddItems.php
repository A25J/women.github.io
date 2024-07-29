<?php
session_start();
include 'conn.php';
// Get the current date
$currentDate = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add item to warehouse</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <nav>
        <ul class="nav-bar">
            <li class="nav"><a href="warehouseSpecialist.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="updateitems.php" class="nav-links" id="update-items">Update Number of Items</a></li>
            <li class="nav"><a href="WaddItems.php" class="nav-links" id="add-items">Add Items</a></li>
            <li class="nav"><a href="WUpdateStatus.php" class="nav-links" id="add-items">Update order status</a></li>
            <li class="nav"><a href="logout.php" class="nav-links" id="add-items">Logout</a></li>
        </ul>
    </nav>

    <section>
        <form action="WaddItems.php" method="post">
            <h1>Add Items to Warehouse</h1>
            <div class="inputbox">
                <ion-icon name="shirt-outline"></ion-icon>
                <input type="text" required name="itemname">
                <label for="">Item name</label>
            </div>
            <div class="inputbox">
                <ion-icon></ion-icon>
                <input type="number" required name="Itemnumber">
                <label for="">Available number of items</label>
            </div>
            <div class="inputbox">
                <ion-icon></ion-icon>
                <input type="date" required name="shipment" value="<?php echo $currentDate; ?>">

                <label for="">Date of last shipment</label>
            </div>
            <div class="inputbox">
                <ion-icon></ion-icon>
                <select name="category" id="" required>
                    <option value="none">Choose Category</option>
                    <?php
                    $stmt = $conn->prepare("SELECT category_name FROM category");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
                    }
                    ?>
                </select>
            </div> <br>
            <button type="submit" name="addItem">Add Item</button>

        </form>
    </section>
</body>

</html>
<style>
    section {
        position: absolute;
        left: 30%;
        width: 400px;
        background-color: transparent;
        border: 2px solid gray;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 3rem;
        top: 15%;
    }

    select {
        width: 50%;
        height: 30px;
        border-radius: 10px;
    }

    h1 {
        font-size: 22px;
        color: rgb(0, 0, 0);
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }

    .inputbox {
        position: relative;
        margin: 30px 0;
        max-width: 310px;
        border-bottom: 2px solid gray;
    }

    .inputbox label {
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translate(-50px);
        color: #000;
        font-size: 1 rem;
        pointer-events: none;
        transition: all 0.5s ease-in-out;
    }

    input:focus~label,
    input:valid~label {
        top: -5px;
    }

    .inputbox input {
        width: 200px;
        height: 50px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 1rem;
        padding: 0 35px 0 5px;
        color: #000;
    }

    .inputbox ion-icon {
        position: absolute;
        right: 8px;
        color: rgb(0, 0, 0);
        font-size: 1.2rem;
        top: 20px;
    }

    button {
        width: 100%;
        height: 40px;
        border-radius: 40px;
        background-color: rgba(255, 255, 255, 1);
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    button:hover {
        background-color: rgb(0, 0, 0);
        color: white;
    }

    .register {
        font-size: 0.9rem;
        color: #000;
        text-align: center;
        margin: 25px 0 10px;
    }

    .register p a {
        text-decoration: none;
        color: #000;
        font-weight: 600;
    }

    .register p a:hover {
        text-decoration: underline;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        vertical-align: middle;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;

        overflow: hidden;
    }

    nav {
        float: right;
        margin-right: 5px;
    }

    .nav-bar {
        list-style: none;
        display: table;
        text-align: center;
    }

    .nav {
        display: table-cell;
        position: relative;
        padding: 15px 0;
        font-family: "Arial", sans-serif;
    }

    .nav-links {
        color: #000000;
        text-decoration: none;
        display: inline-block;
        padding: 15px 20px;
        position: relative;
    }

    .nav-links::after {
        content: "";
        background: none repeat scroll 0 0 transparent;
        display: block;
        height: 4px;
        left: 50%;
        position: absolute;
        background: black;
        transition: width 0.5s ease 0s, left 0.5s ease 0s;
        width: 0%;
        margin: 4px;
    }

    .nav-links:hover::after {
        width: 100%;
        left: 0%;
        background-color: rgb(88, 154, 173);
    }

    /* Media Query for smaller screens */
    @media screen and (max-width: 768px) {
        .logo {
            width: 60%;
        }
    }

    /* Media Query for even smaller screens */
    @media screen and (max-width: 480px) {
        .logo {
            width: 80%;
        }
    }
</style>
<?php
$spec_id = $_SESSION['id'];
if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['addItem'])){
    $item = $_POST['itemname'];
    $quantity = $_POST['Itemnumber'];
    $date = $_POST['shipment'];
    $category = $_POST['category'];
    $stm = $conn->prepare("SELECT category_id FROM category WHERE category_name = ?");
    $stm->bind_param("s", $category);
    $stm->execute();
    $res = $stm->get_result();
    $row = $res->fetch_assoc();
    $stmt = $conn->prepare("INSERT INTO  warehouse (nb_of_product, dateof_last_shipment, category_id, product_name, spec_id)
                            VALUES(?,?,?,?,?)");
    $stmt->bind_param("isisi",$quantity, $date, $row['category_id'], $item,  $spec_id);
    if($stmt->execute()){
        echo "<script>alert('Item added successfully to the warehouse'); </script>";
    }
    $stmt->close();



}
?>