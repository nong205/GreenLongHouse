<?php
include 'components/connection.php';  
session_start();

if (isset($_SESSION['user_id'])) {
    // Chuyển đổi user_id thành số nguyên
    $user_id = intval($_SESSION['user_id']);
} else {
    header("location: login.php");
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
    exit;
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - Long House</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
    <div class="main">
        <div class="banner">
            <h1>Checkout summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>Checkout summary</span>
        </div>
        <section class="checkout">
           <div class="title">
            <img src="img/download.png" class="logo">
            <h1>Checkout summary</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eius tempore delectus perferendis nam sapiente officiis. Dolore, mollitia?</p>
            </div>
            <div class="row">
                <form action="" method="post">
                    <h3>Billing details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>Your name</p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your number</p>
                                <input type="number" name="number" required maxlength="10" placeholder="Enter your number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Your email</p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="input">
                            </div>
                            <div class="input-field">
                                <p>Payment method</p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">Cash on delivery</option>
                                    <option value="credit or debit card">Credit or debit card</option>
                                    <option value="net banking">Net banking</option>
                                    <option value="UPI or RuPay">UPI or RuPay</option>
                                    <option value="paytm">Paytm</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Address type</p>
                                <select name="address_type" class="input">
                                    <option value="home">Home</option>
                                    <option value="office">Office</option>
                                </select>
                            </div> 
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>Address line 1</p>
                                <input type="text" name="flat" required maxlength="50" placeholder="e.g flat & building number" class="input">
                            </div>
                            <div class="input-field">
                                <p>Address line 2</p>
                                <input type="text" name="street" required maxlength="50" placeholder="e.g street name" class="input">
                            </div>
                            <div class="input-field">
                                <p>City name</p>
                                <input type="text" name="city" required maxlength="50" placeholder="Enter your city name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Country name</p>
                                <input type="text" name="country" required maxlength="50" placeholder="Enter your country name" class="input">
                            </div>
                            <div class="input-field">
                                <p>Pincode</p>
                                <input type="text" name="pincode" required maxlength="6" placeholder="110022" min="0" max="999999" class="input">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place order</button>
                </form>
                <div class="summary">
                    <h3>My bag</h3>
                    <div class="box-container">
                        <?php
                        $grand_total = 0;

                        if (isset($_GET['get_id'])) {
                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_get->execute([$_GET['get_id']]);
                            while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total;
                                ?>
                                <div class="flex">
                                    <img src="image/<?=$fetch_get['image']; ?>" class="image" alt="">
                                    <div>
                                        <h3 class="name"><?=$fetch_get['name']; ?></h3>
                                        <p class="price"><?=$fetch_get['price']; ?>/-</p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);
                            if ($select_cart->rowCount() > 0) {
                                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = ($fetch_cart['qty'] * $fetch_products['price']);
                                    $grand_total += $sub_total;
                                    ?>
                                    <div class="flex">
                                        <img src="image/<?=$fetch_products['image']; ?>" alt="">
                                        <div>
                                            <h3 class="name"><?=$fetch_products['name']; ?></h3>
                                            <p class="price"><?=$fetch_products['price']; ?> x <?=$fetch_cart['qty']; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p class='empty'>Your cart is empty</p>";
                            }
                        }
                        ?>
                    </div>
                    <div class="grand-total"><span>total amount payable: </span>$<?= $grand_total ?>/-</div>
                </div>
            </div>
        </section>
       
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
