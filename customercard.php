<?php
session_start();
include('conn.php');

if (!isset($_SESSION['id'])) {
    header('location:Loginform.php');
    exit();
}

$id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM card_info WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$nbrows = $result->num_rows;
if($nbrows > 0){
    header("Location: customerCart.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CreditCard.css">
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Credit Card Form</title>
</head>

<body>

    <div class="container">
        <div class="card-container">
            <div class="front">
                <div class="image">
                    <img src="card/chip.png" alt="">
                    <img src="card/visa.png" alt="">
                </div>
                <div class="card-number-box">################</div>
                <div class="flexbox">
                    <div class="box">
                        <span>card holder</span>
                        <div class="card-holder-name">full name</div>
                    </div>
                    <div class="box">
                        <span>expires</span>
                        <div class="expiration">
                            <span class="exp-month">mm</span>
                            <span class="exp-year">yy</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"></div>
                    <img src="card/visa.png" alt="">
                </div>
            </div>
        </div>

        <form id="cardForm">
            <div class="inputBox">
                <span>card number</span>
                <input type="text" maxlength="16" class="card-number-input" name="cardNumber" required>
            </div>
            <div class="inputBox">
                <span>card holder</span>
                <input type="text" class="card-holder-input" name="cardHolderName" required>
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span>expiration mm</span>
                    <select name="month" class="month-input" required>
                        <option value="" selected disabled>month</option>
                        <!-- Option values for months -->
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $month = str_pad($m, 2, "0", STR_PAD_LEFT);
                            echo "<option value='$month'>$month</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="inputBox">
                    <span>expiration yy</span>
                    <select name="year" class="year-input" required>
                        <option value="" selected disabled>year</option>
                        <!-- Option values for years -->
                        <?php
                        $currentYear = date("Y");
                        for ($y = $currentYear; $y <= $currentYear + 10; $y++) {
                            echo "<option value='$y'>$y</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="inputBox">
                    <span>cvv</span>
                    <input type="text" maxlength="4" class="cvv-input" name="cvv" required>
                </div>
            </div>
            <button type="submit" value="Submit" class="submit-btn" name="submit" onclick="card()"> Submit </button>
        </form>
    </div>

    <script>
        function card() {
            // Update card display on input
            $('.card-number-input').on('input', function() {
                $('.card-number-box').text($(this).val());
            });
            $('.card-holder-input').on('input', function() {
                $('.card-holder-name').text($(this).val());
            });
            $('.month-input').on('input', function() {
                $('.exp-month').text($(this).val());
            });
            $('.year-input').on('input', function() {
                $('.exp-year').text($(this).val());
            });
            $('.cvv-input').on('mouseenter', function() {
                $('.front').css('transform', 'perspective(1000px) rotateY(-180deg)');
                $('.back').css('transform', 'perspective(1000px) rotateY(0deg)');
            }).on('mouseleave', function() {
                $('.front').css('transform', 'perspective(1000px) rotateY(0deg)');
                $('.back').css('transform', 'perspective(1000px) rotateY(180deg)');
            }).on('input', function() {
                $('.cvv-box').text($(this).val());
            });

            // Handle form submission via AJAX
            $('#cardForm').submit(function(e) {
                e.preventDefault();

                // Gather data from form
                var cardNumber = $('.card-number-input').val()
                var cardHolderName = $('.card-holder-input').val()
                var month = $('.month-input').val()
                var year = $('.year-input').val()
                var cvv = $('.cvv-input').val()


                // Send data to the server
                $.ajax({
                    url: 'addcard.php',
                    type: 'POST',
                    data: {
                        cardNumber: cardNumber,
                        cardHolderName: cardHolderName,
                        month: month,
                        year: year,
                        cvv: cvv
                    },
                    success: function(response) {
                        if (response.trim() === 'success') {
                            window.location.href = 'customerCart.php';
                        } else {
                            alert(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });

            });
        }
    </script>

</body>

</html>