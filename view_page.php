<?php
include 'components/connection.php';  
session_start();

if (isset($_SESSION['user_id'])) {
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

if(isset($_POST['add_to_wishlist'])){
    $product_id = intval($_POST['product_id']); 

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

if(isset($_POST['add_to_cart'])){
    $id = unique_id();
    $product_id = intval($_POST['product_id']); 
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    if ($user_id <= 0 || $product_id <= 0) {
        die('Invalid user ID or product ID.');
    }
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
            $insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, product_id, price, qty) VALUES(?, ?, ?, ?, ?)");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
            $success_msg[] = 'Product added to cart successfully!';
        } else {
            $warning_msg[] = 'Product not found.';
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
            <h1>Products Detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>Products Detail</span>
        </div>
        <section class="view_page">
       <?php
       if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT)){
            $pid = intval($_GET['pid']);
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);
            if($select_products->rowCount()>0){
                while($fetch_products =$select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post">
                    <img src="image/<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>">
                    <div class="detail">
                        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="detail">
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laborum ex at debitis? Minus
                                 quos voluptate est consequatur voluptatem quam amet.</p>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <div class="button">
                            <button type="submit" name="add_to_wishlist" class="btn">Add to wishlist <i class="bx bx-heart"></i></button>
                            <input type="hidden" name="qty" value="1" min="0" class="quantity">
                            <button type="submit" name="add_to_cart" class="btn">Add to cart <i class="bx bx-cart"></i></button>
                        </div>
                    </div>
                </form>
                <?php
                }
            } else {
                echo "<p>Product not found.</p>";
            }
       } else {
           echo "<p>Invalid product ID.</p>";
       }
       ?>
        </section>
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
