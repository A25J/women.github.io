<?php
session_start();
include "conn.php";

if (!isset($_SESSION['id'])) {
  echo "<script>alert('You must be logged in..'); window.location.href='Loginform.php';</script>";
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($_GET['category']); ?> Products</title>
  <link rel="icon" type="image/png" href="/women/images/logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
  </nav><br><br>

  <?php
  $category = $_GET['category'];
  $stmt1 = $conn->prepare("SELECT category_id FROM category WHERE category_name = ?");
  $stmt1->bind_param('s', $category);
  $stmt1->execute();
  $res1 = $stmt1->get_result();
  $row = $res1->fetch_assoc();

  $stmt2 = $conn->prepare("SELECT * FROM product WHERE category_id = ?");
  $stmt2->bind_param('i', $row['category_id']);
  $stmt2->execute();
  $res2 = $stmt2->get_result();
  ?>
  <div class="display" id="display">
    <div class="buttons">
      <i class="fa fa-th-large" id="showdiv1" aria-hidden="true"></i> &nbsp;
      <i class="fa fa-th-list" id="showdiv2" aria-hidden="true"></i>
    </div>

    <div class="container">
      <div id="div1">
        <section class="section-grid">
          <div class="product-grid">
            <?php while ($row = $res2->fetch_assoc()) { ?>
              <div class="prod-grid">
                <img src="<?php echo "images/products/" . htmlspecialchars($row['product_image']); ?>" alt="Product Image" width="200" height="200">
                <h3>price : $ <?php echo htmlspecialchars($row['unit_price']); ?></h3>
                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                <?php
                $st = $conn->prepare("SELECT * FROM specification WHERE product_id = ?");
                $st->bind_param("i", $row['product_id']);
                $st->execute();
                $res = $st->get_result();
                $r = $res->fetch_assoc();
                ?>
                <h3>Specification : </h3>
                <p>brand: <?php echo $r['brand']; ?></p>
                <p>material: <?php echo $r['material']; ?></p>
                <p><?php if ($r['boycott'] == '0') echo "none boycott";
                    else  echo "boycott"; ?></p>

                <form class="productForm">
                  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                  <button class="btn" type="submit">Add to cart <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                </form>
              </div>
            <?php } ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</body>

</html>
<style>
  .display {
    text-align: center;
  }

  .container {
    position: relative;
    padding: 10px;
    margin: 10px;
    font-family: "Arial", sans-serif;
  }

  .buttons {
    font-size: 17px;
    margin-bottom: 1em;
    text-align: center;
  }

  .fa-th-large,
  .fa-th-list {
    cursor: pointer;
    color: #333;
  }

  .fa-th-large:hover,
  .fa-th-list:hover {
    color: darkcyan;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    justify-items: center;
    padding: 20px;
  }

  .prod-grid {
    background: linear-gradient(to top, lightgrey, hsl(0, 0%, 52%), white);
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    padding: 1rem;
    text-align: center;
    width: 220px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .prod-grid img {
    max-width: 100%;
    height: auto;
  }

  .prod-grid:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 139, 139, 0.6);
  }

  h3 {
    margin: 1em 0;
    font-size: 15px;
    color: #333;
  }

  /* Button styling */
  .btn {
    background: darkcyan;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 1em;
    padding: 0.5em 1em;
    margin: 0.5em 0;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
    width: 170px;
  }

  .btn:hover {
    background: white;
    color: darkcyan;
    border: 1px solid darkcyan;
  }

  /* Responsive styling for smaller screens */
  @media (max-width: 768px) {
    .product-grid {
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }

    .prod-grid {
      width: 80%;
    }

    .nav-bar {
      flex-direction: column;
    }
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

  body {
    background-color: rgb(202, 202, 171);
  }

  .prod-grid img {
    height: 300px;
  }
  .section-grid{
    margin-left: 170px;
  }
</style>


<script>
  $(document).ready(function() {
    $('.productForm').on('submit', function(event) {
      event.preventDefault();
      var form = $(this);
      var product_id = form.find('input[name="product_id"]').val();
      var product_name = form.find('input[name="product_name"]').val();

      $.ajax({
        url: 'add_to_cart.php',
        type: 'POST',
        data: {
          product_id: product_id,
          product_name: product_name,
          sent: true
        },
        success: function(response) {
          alert('Item is added to cart');
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });
  });
</script>