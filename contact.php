<?php
include 'components/connection.php';  
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header("location: login.php"); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
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
    <link href="path/to/boxicons.min.css" rel="stylesheet">


    <title>Green Coffee - Long House</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
    <div class="main">
    <div class="banner">
            <h1>Contact Long's House</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>Contact</span>
        </div>
        <section class="services">
    <div class="box-container">
        <div class="box">
            <img src="img/icon2.png" alt="">
            <div class="detail">
                <h3>great savings</h3>
                <p>save big every order</p>
            </div>
        </div>
        <div class="box">
            <img src="img/icon1.png" alt="">
            <div class="detail">
                <h3>27*7 support</h3>
                <p>one-on-one support</p>
            </div>
        </div>
        <div class="box">
            <img src="img/icon0.png" alt="">
            <div class="detail">
                <h3>gift vouchers</h3>
                <p>vouchers on every festivals</p>
            </div>
        </div>
        <div class="box">
            <img src="img/icon.png" alt="">
            <div class="detail">
                <h3>worldwide delivery</h3>
                <p>dropship worldwide</p>
            </div>
        </div>
    </div>
</section>
<div class="form-container">
    <form action="" method = "post">
        <div class="title">
            <img src="img/download.png" alt="">
            <h1>Leave a message</h1>
        </div>
        <div class="input-field">
            <p>Your name <sup>*</sup></p>
            <input type="text" name="name" id="">
        </div>
        <div class="input-field">
            <p>Your Email <sup>*</sup></p>
            <input type="text" name="email" id="">
        </div>
        <div class="input-field">
            <p>Your number <sup>*</sup></p>
            <input type="text" name="number" id="">
        </div>
        <div class="input-field">
            <p>Your message <sup>*</sup></p>
            <textarea name="message"></textarea>
        </div>
        <button type="submit" name="submit-btn" class="btn">Send message</button>
    </form>
    

</div>
<div class="address">
    <div class="title">
            <img src="img/download.png" alt="">
            <h1>Contact detail</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit qui voluptates veritatis culpa iure est, repudiandae provident praesentium dolorem id? Eveniet incidunt voluptas assumenda sequi impedit reiciendis molestiae, similique cum.</p>
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-pin"></i>
                <div>
                    <h4>address</h4>
                    <p>Near CNTT-VIETHAN,DaNang</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-call"></i>
                <div>
                    <h4>Phone number</h4>
                    <p>0987056868</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-map-pin"></i>
                <div>
                    <h4>Email</h4>
                    <p>Longthanhnct@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
