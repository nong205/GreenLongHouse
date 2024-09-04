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
            <h1>Orders</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>Orders</span>
        </div>
        <section class="products">
            <div class="box-container">
                <div class="title">
                    <img src="img/download.png" class="logo" alt="">
                    <h1>My order</h1>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores, quam? Nemo 
                        ut aut explicabo minus vero, quidem architecto quisquam alias?</p>
                </div>
                <div class="box-container">
                    <?php 
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                    $select_order->execute([$user_id]);
                    if($select_order->rowCount() > 0){
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_products->execute([$fetch_order['product_id']]);
                            if($select_products->rowCount() > 0){
                                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="box" <?php if($fetch_order['status'] == 'cancel'){
                        echo 'style="border:2px solid red";';} ?>>
                        <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                            <p class="date"><i class="bi bi-calendar-fill"></i><span><?= $fetch_order['date']; ?></span></p>
                            <img src="image/<?= $fetch_product['image']; ?>" class="image">
                            <div class="row">
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <p class="price">Price: $<?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                <p class="status" style="color: <?php 
                                    if($fetch_order['status'] == 'delivered'){
                                        echo 'green';
                                    } elseif($fetch_order['status'] == 'canceled'){
                                        echo 'red';
                                    } else {
                                        echo 'orange';
                                    } 
                                ?>;">
                                    <?= ucfirst($fetch_order['status']); ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <?php
                                }
                            }
                        }
                    } else {
                        echo '<p class="empty">No orders placed yet.</p>';
                    }
                    ?>
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
