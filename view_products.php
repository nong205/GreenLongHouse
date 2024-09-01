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

// Thêm sph vào ds e.yeu
if(isset($_POST['add_to_wishlist'])){
    $product_id = intval($_POST['product_id']); 

    // Kiểm tra giá trị của user_id và product_id
    if ($user_id <= 0 || $product_id <= 0) {
        die('Invalid user ID or product ID.');
    }

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if($varify_wishlist->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } else if($cart_num->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        if ($fetch_price) {
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, product_id, price) VALUES(?, ?, ?)");
            $insert_wishlist->execute([$user_id, $product_id, $fetch_price['price']]);
            $success_msg[] = 'Product added to wishlist successfully!';
        } else {
            die('Product not found.');
        }
    }
}

// Thêm sph vào giỏ hàng
if(isset($_POST['add_to_cart'])){
    $product_id = intval($_POST['product_id']); 
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    if ($user_id <= 0 || $product_id <= 0) {
        $warning_msg[] = 'Invalid user ID or product ID.';
    } else {
        try {
            $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
            $varify_cart->execute([$user_id, $product_id]);

            $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $max_cart_items->execute([$user_id]);

            if($varify_cart->rowCount() > 0){
                $warning_msg[] = 'Product already exists in your cart';
            } else if($max_cart_items->rowCount() >= 20){
                $warning_msg[] = 'Cart is full';
            } else {
                $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                if ($fetch_price) {
                    $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, product_id, price, qty) VALUES(?, ?, ?, ?)");
                    $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);
                    $success_msg[] = 'Product added to cart successfully!';
                } else {
                    $warning_msg[] = 'Product not found.';
                }
            }
        } catch (PDOException $e) {
            $warning_msg[] = 'Error: ' . $e->getMessage();
        }
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
            <h1>Shop Long's House</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>Our shop</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php 
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                if($select_products->rowCount() > 0){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="box">
                    <img src="image/<?=$fetch_products['image']; ?>" class="img">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?=$fetch_products['id']; ?>" class="bx bx-show"></a>
                    </div>
                    <h3 class="name"><?=$fetch_products['name']; ?></h3>
                    <input type="hidden" name="product_id" value="<?=$fetch_products['id']; ?>">
                    <div class="flex">
                        <p class="price">Price $<?=$fetch_products['price']; ?>/-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?=$fetch_products['id']; ?>" class="btn">Buy now</a>
                </form>

                <?php 
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
                ?>
            </div>
        </section>
       
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
