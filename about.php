<?php
include 'components/connection.php';  
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


    <title>Green Coffee -About Long House</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
    <div class="main">
        <div class="banner">
            <h1>About Long's House</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>About</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="img/3.webp" alt="">
                <div class="detail">
                    <span>Coffee</span>
                    <h1>Lemon green</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/2.webp" alt="">
                <div class="detail">
                    <span>Coffee</span>
                    <h1>Lemon Teaname</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/about.png" alt="">
                <div class="detail">
                    <span>Coffee</span>
                    <h1>Lemon Teaname</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="img/1.webp" alt="">
                <div class="detail">
                    <span>Coffee</span>
                    <h1>Lemon green</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <img src="img/download.png" alt="" class="logo">
                <h1>Why choose us</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem.</p>
            </div>
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
 <div class="about">
    <div class="row">
        <div class="img-box">
            <img src="img/3.png" alt="">
        </div>
        <div class="detail">
            <h1>visit our beautiful showroom</h1>
            <p>Our showroom is an expression of what love doing,being</p>
            <a href="view_products.php" class="btn">shop now</a>
        </div>
    </div>
 </div>
 <div class="testimonial-container">
        <div class="title">
        <img src="img/download.png" class="logo" alt="">
        <h1>What people say about us</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint?</p>  
        </div>
        <div class="container">
            <div class="testimonial-item active">
                <img src="img/Chup-anh-the-cho-be-tai-tphcm-2.jpg" style="width: 6rem;hight: auto" alt="">
                <h1>Thuanhitboy</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Atque laudantium provident veniam, magni aspernatur perspiciatis nesciunt suscipit 
                    alias obcaecati incidunt sequi eos corrupti fuga totam odit quod assumenda officiis eligendi?</p>
            </div>
            <div class="testimonial-item ">
                <img src="img/2716536792_3c36120983.jpg" style="width: 6rem;hight: auto" alt="">
                <h1>Loghitboy</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Atque laudantium provident veniam, magni aspernatur perspiciatis nesciunt suscipit 
                    alias obcaecati incidunt sequi eos corrupti fuga totam odit quod assumenda officiis eligendi?</p>
            </div>
            <div class="testimonial-item ">
                <img src="img/Chup-anh-the-cho-be-tai-tphcm.jpg" style="width: 6rem;hight: auto" alt="">
                <h1>Who-hitboy</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Atque laudantium provident veniam, magni aspernatur perspiciatis nesciunt suscipit 
                    alias obcaecati incidunt sequi eos corrupti fuga totam odit quod assumenda officiis eligendi?</p>
            </div>
            <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
            <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
        </div>

 </div>
    <?php include 'components/footer.php'; ?>   
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="./script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
