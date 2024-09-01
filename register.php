<?php
include 'components/connection.php';
session_start();

$message = [];

if (isset($_POST['submit'])) {
    $id = unique_id(); 
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
    $cpass = htmlspecialchars($_POST['cpass'], ENT_QUOTES, 'UTF-8');
    
    if (!$email) {
        $message[] = 'Email không hợp lệ';
    } else {
        $select_user = $conn->prepare("SELECT id FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
    
        if ($select_user->rowCount() > 0) {
            $message[] = 'Email đã tồn tại';
        } else {
            if ($pass != $cpass) {
                $message[] = 'Xác nhận mật khẩu không khớp';
            } else {
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                
                try {
                    $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)");
                    $insert_user->execute([$name, $email, $hashed_pass]);
                
                    $_SESSION['user_id'] = $conn->lastInsertId(); // Lấy ID mới chèn vào
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                
                    header("Location: home.php");
                    exit;
                } catch (PDOException $e) {
                    $message[] = 'Lỗi khi đăng ký: ' . $e->getMessage();
                }
                
            }
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
    <title>Green Tea - Register Now</title>
</head>
<body>
    <div class="form-container">
        <section class="form-section">
            <div class="title">
                <img src="img/download.png" alt="Green Tea">
                <h1>Register Now</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit nam quis nesciunt sapiente veritatis voluptates vel distinctio harum mollitia culpa modi officia tempora dolorem, minima maiores expedita, asperiores cumque qui!</p>
            </div>
            <?php if (!empty($message)) : ?>
                <div class="alert">
                    <?php foreach ($message as $msg) : ?>
                        <p><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Name</p>
                    <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Email</p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Your Password</p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Confirm Password</p>
                    <input type="password" name="cpass" required placeholder="Enter your password again" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="login.php">Login Now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
