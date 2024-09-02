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

if(isset($_POST['place_order'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'];
    $address = filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if(isset($_GET['get_id'])){
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);
        if($get_product->rowCount()>0){
            while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)){
                $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, address, 
                address_type, method, product_id, price, qty, date, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

                if ($insert_order->execute([$user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1, date('Y-m-d H:i:s'), 'pending'])) {
                    error_log("Order placed successfully");
                    header('location: order.php');
                    exit;
                } else {
                    error_log("Failed to place order: " . implode(", ", $insert_order->errorInfo()));
                }
            }
        } else {
            $warning_msg[] = 'Something went wrong.';
        }
    } elseif ($verify_cart->rowCount() > 0) {
        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$f_cart['product_id']]);
            $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

            $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, address, address_type, method, product_id, price, qty, date, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

            if ($insert_order->execute([$user_id, $name, $number, $email, $address, $address_type, $method, $fetch_product['id'], $f_cart['price'], $f_cart['qty'], date('Y-m-d H:i:s'), 'pending'])) {
                error_log("Order placed successfully");
            } else {
                error_log("Failed to place order: " . implode(", ", $insert_order->errorInfo()));
            }
        }

        if ($insert_order) {
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);
            header('location: order.php');
            exit;
        }
    } else {
        $warning_msg[] = 'Something went wrong.';
    }
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
