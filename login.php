<?php
include 'components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

$message = []; // Khởi tạo biến $message

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

    if ($email && $pass) {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header('Location: home.php');
            exit;
        } else {
            $message[] = 'Incorrect email or password';
        }
    } else {
        $message[] = 'Please fill in all fields';
    }
}
?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green tea - Login now</title>
</head>
<body>
    <div class="form-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png" alt="">
                <h1>Login now</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit nam quis nesciunt sapiente veritatis voluptates vel distinctio harum mollitia culpa modi officia tempora dolorem, minima maiores expedita, asperiores cumque qui!</p>
            </div>
            <?php if (!empty($message)) : ?>
                <div class="alert">
                    <?php foreach ($message as $msg) : ?>
                        <p><?php echo htmlspecialchars($msg); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your email</p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Your password</p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <input type="submit" name="submit" value="Login now" class="btn">
                <p>Do not have an account? <a href="register.php">Register now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
