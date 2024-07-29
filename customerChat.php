<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
</head>

<body>
    <header>
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
    </header>
    <br><br>
    <div class="send">
        <div id="chatMessages">
            <?php
            session_start();
            include 'conn.php';

            if (!isset($_SESSION['id'])) {
                echo "<script>alert('you must be logged in... '); window.location.href = 'Loginform.php';</script>";
                exit();
            }

            $designer_id = $_GET['designer'];
            $designer = "";

            $stmt = $conn->prepare("SELECT * FROM fashion_designer WHERE designer_id = ?");
            $stmt->bind_param('i', $designer_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $designer = $row['designer_username'];

            $sql = $conn->prepare("SELECT * from messages WHERE customer_id = ? AND designer_id = ?");
            $cid = $_SESSION['id'];
            $sql->bind_param('ii', $cid, $designer_id);
            $sql->execute();
            $result = $sql->get_result();
            while ($row = $result->fetch_assoc()) {
                echo '<div class="in-message">' . htmlspecialchars($row['in-message']) . '</div><br><br>';
                if (!empty($row['out-message'])) {
                echo '<div class="out-message">' . htmlspecialchars($row['out-message']) . '</div><br><br>';
                }
            }
            ?>
        </div>
        <br><br>
        <form id="chatForm">
            <textarea name="chatting" id="chatting" placeholder="Enter your message here..."></textarea>
            <button type="submit">Send</button>
            <input type="hidden" id="designer_id" value="<?php echo $_GET['designer']; ?>">
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#chatForm').on('submit', function(event) {
                event.preventDefault();
                var message = $('#chatting').val();
                var designer_id = $('#designer_id').val();
                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }

                $.ajax({
                    url: 'customerChatScript.php',
                    type: 'POST',
                    data: {
                        chatting: message,
                        sending: true,
                        designer_id: designer_id
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
        margin-left: 200px;
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
        background-color: #ff6347;
        color: white;
        float: right;
        clear: both;

    }

    .out-message {
        background-color: #f0f0f0;
        float: left;
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
</style>