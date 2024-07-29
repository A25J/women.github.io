<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
</head>

<body>
    <header>
        <nav>
            <ul class="nav-bar">
                <li class="nav"> <a href="logout.php" class="nav-links" id="login">Logout</a></li>
                <li class="nav"><a href="#" class="nav-links" id="account">Account</a></li>
            </ul>
        </nav>
    </header> <br><br>
    <div class="send">
        <div id="chatMessages">
            <?php
            session_start();
            include 'conn.php';

            if (!isset($_SESSION['id'])) {
                echo "<script>alert('You must be logged in... '); window.location.href = 'Loginform.php';</script>";
                exit();
            }

            $customer_id = $_GET['customer'];
            $customer = "";

            $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_id = ?");
            $stmt->bind_param('i', $customer_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $customer = $row['customer_username'];

            $sql = $conn->prepare("SELECT * FROM messages WHERE designer_id = ? AND customer_id = ?");
            $did = $_SESSION['id'];
            $sql->bind_param('ii', $did, $customer_id);
            $sql->execute();
            $result = $sql->get_result();

            while ($row = $result->fetch_assoc()) {
                if (!empty($row['in-message'])) {
                    echo '<div class="in-message">' . htmlspecialchars($row['in-message']) . '</div><br><br>';
                }
                echo '<div class="out-message">' . htmlspecialchars($row['out-message']) . '</div><br><br>';
            }
            $stmt1 = $conn->prepare("SELECT body_information.*, customer.* FROM body_information 
            JOIN customer ON body_information.customer_id = customer.customer_id 
            WHERE body_information.customer_id = ?");
            $stmt1->bind_param("i", $customer_id);
            $stmt1->execute();
            $resl = $stmt1->get_result();
            $rowl = $resl->fetch_assoc();
            $user = $rowl['customer_username'];
            $height = $rowl['height'];
            $weight = $rowl['weight'];
            $bodyshape = $rowl['body_shape'];
            $color = $rowl['skin_color'];
            $tone = $rowl['skin_tone'];
            ?>
        </div>
        <br><br>
        <form id="chatForm">
            <textarea name="chatting" id="chatting" placeholder="Enter your message here..."></textarea>
            <button type="submit">Send</button>
            <input type="hidden" id="designer_id" value="<?php echo $_GET['customer']; ?>">
        </form>
    </div>
    <aside>
        <?php

        echo "<div class = 'customer_info'>
        <h2>Customer Information</h2>
                <table>
                <tr> <td><b>Customer Username</b></td>
                    <td>$user</td> </tr>
                <tr> <td> <b> Height </b></td>
                    <td> $height </td></tr>
                <tr> <td> <b> Weight </b> </td>
                <td> $weight </td></tr>
                <tr> <td> <b> Body Shape </b></td>
                <td> $bodyshape </td></tr>
                <tr> <td> <b> Skin Color </b></td>
                <td> $color  </td></tr>
                <tr> <td> <b> Skin Tone </b> </td>
                <td> $tone </td> </tr> 
                </table>
         </div>";
        ?>
    </aside>
    <script>
        $(document).ready(function() {
            $('#chatForm').on('submit', function(event) {
                event.preventDefault();
                var message = $('#chatting').val();
                var customer_id = $('#designer_id').val();
                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }

                $.ajax({
                    url: 'designerChatScript.php',
                    type: 'POST',
                    data: {
                        chatting: message,
                        sending: true,
                        customer_id: customer_id
                    },
                    success: function(response) {
                        $('#chatMessages').html(response);
                        $('#chatting').val('');
                    }
                });
            });
        });
    </script>

</body>

</html>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        background-repeat: no-repeat;
        background-size: cover;
        vertical-align: middle;
        overflow-x: hidden;
        background-attachment: fixed;
        width: 100vw;
        background-image: url("Model (2).jbeg");
    }

    nav {

        position: relative;
        flex-wrap: wrap;
        width: 100vw;
        margin-right: 5px;


    }


    .nav-bar {
        position: relative;
        list-style: none;
        display: table;
        text-align: center;
        float: right;
    }

    .nav {

        display: table-cell;
        position: sticky;
        padding: 15px 0;
        font-family: "Arial", sans-serif;

    }

    .nav-links {
        color: black;
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


    @media screen and (max-width: 768px) {
        .logo {
            width: 150px;
        }

        .card {
            width: 100%;
        }
    }

    @media screen and (max-width: 480px) {
        .nav-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .nav {
            display: block;
            padding: 10px 0;
            text-align: center;
            display: none;
        }

        .nav-links {
            display: block;
            padding: 10px 0;
        }


        .logo-container {
            padding: 10px;
        }

        .card {
            width: 100%;
        }

    }

    .send {
        width: 100%;
        max-width: 600px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 100px;
        margin-left: 50px;
        float: right;
    }

    #chatForm {
        display: flex;
        flex-direction: column;
    }

    #chatting {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        font-size: 14px;
        resize: none;
    }

    #chatForm button {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #ff6347;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #chatForm button:hover {
        background-color: #ff4500;
    }

    #chatMessages {
        margin-top: 20px;
    }

    .in-message,
    .out-message {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        max-width: 70%;
        clear: both;
        position: relative;
    }

    .in-message {

        background-color: #f0f0f0;
        float: left;
        clear: both;
    }

    .out-message {
        background-color: #ff6347;
        color: white;
        float: right;
        clear: both;

    }

    .in-message:after,
    .out-message:after {
        content: '';
        position: absolute;
        border-width: 6px;
        border-style: solid;
        display: block;
    }

    .in-message:after {
        border-color: transparent transparent transparent #f0f0f0;
        top: 10px;
        left: -12px;
    }

    .out-message:after {
        border-color: transparent #ff6347 transparent transparent;
        top: 10px;
        right: -12px;
    }
    .customer_info{
        border-radius: 10px;
        float: right;
        margin-top: 100px;
        margin-right: 50px;
        background-color: #ff6347;
        padding: 20px;

    }
    .customer_info h2{
        color: white;
        font-size: 20px;
        margin-left: 2%;
    }
    .customer_info td{
        padding: 5px;
    }

</style>