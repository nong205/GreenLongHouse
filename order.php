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
                
            </div>
        </section>
       
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
