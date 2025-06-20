<?php
session_start();
if (!empty($_SESSION['role'])){
    header('Location: index.php');
    exit;
}
require 'utils/connection.php';

$loginErr = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $loginErr = "Email i lozinka su obavezni!";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loginErr = "Unesite ispravan email!";
    } else {
        $sql = ("SELECT * FROM users WHERE email = '$_POST[email]'");
        $result = $konekcija->query($sql);
        if ($result->num_rows === 0) {
            $loginErr = "Nalog sa ovom email adresom ne postoji!";
        } else {
            $user = $result->fetch_assoc();
            if (!password_verify($password, $user['password'])) {
                $loginErr = "Pogrešna lozinka!";
            } else {
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['user_id'];
                header('Location: index.php');
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava | Organic Health CG</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="/web-shop/js/login.js"></script>
</head>
<body>
<header>
    <div class="container header-content">
        <div class="logo">
            <a href="index.php">
                <img src="/web-shop/slike/logo.jpg" alt="">
            </a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="products.php">Proizvodi</a></li>
                <li><a href="misc/about.php">O nama</a></li>
                <li><a href="misc/contact.php">Kontakt</a></li>
            </ul>
        </nav>
        <div class="user-actions">
        </div>
    </div>
</header>
<main>
    <div class="container auth-container">
        <form id="loginForm" class="auth-form" method="post" action="login.php">
            <h2>Prijava</h2>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" onkeyup="checkLoginValidation()">
            <span id="mailErr"></span>
            <label for="password">Lozinka</label>
            <input type="password" id="password" name="password" onkeyup="checkLoginValidation()">
            <span id="passErr"></span>
            <button type="submit" class="auth-btn" id="loginBtn" name="login" disabled>Prijavi se</button>
            <span style="color:red;"><?php echo $loginErr; ?></span>
            <p class="auth-switch">Nemas nalog? <a href="register.php">Registruj se</a></p>
        </form>
    </div>
</main>
<footer>
    <div class="container footer-content">
        <div class="footer-left">
            <p>&copy; 2025 OrganicHealth CG</p>
        </div>
        <div class="footer-right">
                <span class="footer-location">
                    <i class="fas fa-map-marker-alt"></i>
                    Rozaje, Crna Gora
                </span>
            <span class="footer-social">
                    <a href="https://www.instagram.com/organichealthcg" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/p/Organic-Health-CG-61553907063139/" target="_blank" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </span>
        </div>
    </div>
</footer>
</body>
</html>