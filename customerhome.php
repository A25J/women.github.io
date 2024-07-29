<?php
session_start();
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/png" href="/women/images/logo.png">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
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
    <div class="logo-container">
        <img src="images/logo.png" alt="Logo" class="logo" height="200px">
    </div>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            $sql1 = "SELECT category_name, category_image FROM category";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute();
            $results = $stmt1->get_result();
            while ($row = $results->fetch_assoc()) {
            ?>
            <div class="swiper-slide">
                <a href="CustomerProduct.php?category=<?= htmlspecialchars($row['category_name']) ?>" style="text-decoration: none;">
                    <article class="card">
                        <figure>
                            <img src="images/<?= htmlspecialchars($row['category_image']) ?>" alt="<?= htmlspecialchars($row['category_name']) ?>" class="cat">
                            <figcaption>
                                <h3><?= htmlspecialchars($row['category_name']) ?></h3>
                            </figcaption>
                        </figure>
                    </article>
                </a>
            </div>
            <?php 
            }
            $stmt1->close();
            ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            }
        });
    </script>
</body>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: rgb(202, 202, 171);
        overflow-x: hidden;
        background-attachment: fixed;
        width: 100vw;
    }

    nav {
        width: 100%;
        position: fixed;
        top: 0;
        z-index: 1000;
    }

    .nav-bar {
        list-style: none;
        display: flex;
        justify-content: flex-end;
        padding: 10px 20px;
    }

    .nav {
        margin-left: 20px;
    }

    .nav-links {
        color: black;
        text-decoration: none;
        padding: 10px 15px;
        position: relative;
    }

    .nav-links::after {
        content: "";
        display: block;
        height: 4px;
        left: 50%;
        position: absolute;
        background: black;
        transition: width 0.5s ease, left 0.5s ease;
        width: 0;
    }

    .nav-links:hover::after {
        width: 100%;
        left: 0;
        background-color: rgb(88, 154, 173);
    }

    .logo-container {
        text-align: center;
        margin: 80px 0 20px 0;
    }

    .swiper-container {
        width: 100%;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        width: 200px;
        height: 250px;
        border-radius: 8px;
        transition: 0.5s all;
        transform-origin: center left;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .card:hover {
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 20px #00fffc;
    }

    figcaption{
        display: none;
    }

    .card:hover figcaption {
        font-size: 1rem;
        position: absolute;
        height: 60px;
        width: 100%;
        display: flex;
        align-items: flex-end;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0) 100%);
        color: white;
        left: 0;
        bottom: 0;
        padding-left: 12px;
        padding-bottom: 10px;
    }
</style>
</html>
