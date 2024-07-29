<?php
session_start();
include 'conn.php';
$customerid = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM body_information WHERE customer_id = ?");
$stmt->bind_param("i", $customerid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$nbrows = $res->num_rows;
if ($nbrows > 0) {
    header("Location: customerCommunication.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body Information</title>
</head>

<body>
<nav>
        <ul class="nav-bar">
            <li class="nav"><a href="customerhome.php" class="nav-links" id="home">Home</a></li>
            <li class="nav"><a href="customerCart.php" class="nav-links" id="cart">Cart</a></li>
            <li class="nav"><a href="bodyy.php" class="nav-links" id="support">Get Support</a></li>
            <li class="nav"><a href="customerTrackOrder.php" class="nav-links" id="track">Track order</a></li>
            <li class="nav">
                <?php 
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php" class="nav-links" id="login">Logout</a>';
                } else {
                    echo '<a href="Loginform.php" class="nav-links" id="login">Login</a>';
                }
                ?>
            </li>
            <li class="nav"><a href="customerAccount.php" class="nav-links" id="account">Account</a></li>
        </ul>
    </nav>
    <section>
        <form action="bodyInfo.php" method="post">
            <h1>Fill in the following form to chat with the designer</h1>
            <div class="inputbox">
                <ion-icon></ion-icon>
                <input type="number" required name="height">
                <label for="">Height</label>
            </div>
            <div class="inputbox">
                <ion-icon></ion-icon>
                <input type="text" required name="weight">
                <label for="">Weight</label>
            </div>
            <select name="body-shape" id="" required>
                <option value="none" selected>choose body shape</option>
                <option value="hourglass">Hourglass</option>
                <option value="pear">Pear</option>
                <option value="apple">Apple</option>
                <option value="rectangle">Rectangle</option>
                <option value="inverted-triange">Inverted Triangle</option>
                <option value="spoon">Spoon</option>
                <option value="diamond">Diamond</option>
            </select>
            <br><br>
            <select name="skin-color" id="" required>
                <option value="none">Choose your skin color</option>
                <option value="pale-white">Light, pale white</option>
                <option value="white-fair">White, fair</option>
                <option value="white-brown">Medium white to light brown</option>
                <option value="moderate-brown">Olive, moderate brown</option>
                <option value="brown">Brown, dark brown</option>
                <option value="dark">Very dark brown to black </option>
            </select> <br><br>

            <select name="skin-tone" id="" required>
                <option value="none">Choose your skin tone</option>
                <option value="fair">Fair</option>
                <option value="light">Light</option>
                <option value="medium">Medium</option>
                <option value="olive">Olive</option>
                <option value="tan">Tan</option>
                <option value="brown">Brown</option>
                <option value="deep">Deep</option>
            </select><br><br>
            <button type="submit" name="comm">Communicate</button>
        </form>

    </section>
</body>

</html>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-image: url('images/Model\ \(2\).jpeg');
        background-repeat: no-repeat;
        background-size: cover;
        vertical-align: middle;
    }

    nav {
        display: flex;
        margin-right: 5px;
        float: right;
        align-items: center;
        justify-content: space-between;
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
        color: #000;
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
        background: grey;
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

    section {
        position: absolute;
        left: 30%;
        width: 400px;
        background-color: transparent;
        border: 2px solid rgb(88, 154, 173);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        display: flex;
        padding: 2rem 3rem;
        top: 15%;
        height: auto;
        justify-content: center;
        align-items: center;
    }

    .inputbox {
        position: relative;
        margin: 30px;
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
        top: -10px;
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

    .inputfile label {
        font-size: 1rem;
        pointer-events: none;

    }

    .inputfile input {
        /* Make the file field invisible but keep it available for form submission */
        display: flex;
        background: transparent;
        border: none;
        outline: none;
        padding: 10px;
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
        background-color: rgb(88, 154, 173);
        color: white;
    }

    .inputbox ion-icon {
        position: absolute;
        right: 8px;
        color: rgb(0, 0, 0);
        font-size: 1.2rem;
        top: 20px;
    }

    h1 {
        font-size: 32px;
        /* Set the font size */
        color: white;
        /* Set the text color */
        text-align: center;
        /* Align the text to the center */
        margin-top: 20px;
        /* Add some top margin */
        font-family: Arial, sans-serif;
        /* Specify the font family */
    }

    h2 {
        color: #000;
        text-decoration: underline solid rgb(88, 154, 173);
    }

    hr {
        color: rgb(88, 154, 173);
        font-weight: bold;
    }

    select {
        padding: 0 0 0 5px;
        border-radius: 5px;
        height: 25px;
        background-color: beige;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    option {
        background-color: transparent;
    }
</style>