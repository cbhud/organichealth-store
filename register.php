<?php
session_start();
if (!empty($_SESSION['role'])){
    header('location:index.php');
}
require 'utils/connection.php';

$regErr = "";

if (isset($_POST['register'])) {
    extract($_POST);

    if (!validateInput($name, $email, $phone, $password)) {
    } else {
        $parts = explode(" ", $name, 2);
        $first_name = $parts[0];
        $last_name = isset($parts[1]) ? $parts[1] : '';
        $password = password_hash($password, PASSWORD_DEFAULT);
        $role = "user";
        $sql = $konekcija->prepare("INSERT INTO users (first_name, last_name, password, email, phone_number, role) VALUES (?,?,?,?,?,?)");
        $sql->bind_param("ssssss", $first_name, $last_name, $password, $email, $phone, $role);
        $sql->execute();
        echo "<script>alert('USPJESNA REGISTRACIJA!');</script>";
        echo "<script>location.href='login.php';</script>";
    }
}

function validateInput($name, $email, $phone, $password)
{
    global $konekcija;
    global $regErr;

    $name = trim($name);
    $email = trim($email);
    $phone = trim($phone);
    $password = trim($password);

    if (strlen($name) < 3) {
        $regErr = "Ime i prezime moraju imati najmanje 3 karaktera.";
        return false;
    }

    if (strlen($password) < 8) {
        $regErr = "Lozinka mora imati najmanje 8 karaktera.";
        return false;
    }


    if (!preg_match('/^\d{9}$/', $phone)) {
        $regErr = "Broj telefona mora imati tačno 9 cifara.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $regErr = "Email adresa nije validna!";
        return false;
    }

    $sql2 = $konekcija->prepare("SELECT * FROM users WHERE email = ?");
    $sql2->bind_param("s", $email);
    $sql2->execute();
    $result = $sql2->get_result();
    if ($result && $result->num_rows > 0) {
        $regErr = "Nalog sa tom email adresom već postoji!";
        $sql2->close();
        return false;
    }
    $sql2->close();

    return true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija | Organic Health CG</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/jpg" href="slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="/web-shop/js/register.js"></script>
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
        <div class="user-actions"></div>
    </div>
</header>
<main>
    <div class="container auth-container">
        <form id="registerForm" class="auth-form" method="post" action="register.php">
            <h2>Registracija</h2>
            <label for="name">Ime i prezime</label>
            <input type="text" id="name" name="name" onkeyup="checkValidation()"><span id="nameErr"></span>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" onkeyup="checkValidation()"><span id="mailErr"></span>
            <label for="phone">Telefon</label>
            <input type="text" id="phone" name="phone" onkeyup="checkValidation()" ><span id="phoneErr"></span>
            <label for="password">Lozinka</label>
            <input type="password" id="password" name="password" onkeyup="checkValidation()"> <span id="passErr"></span>
            <button type="submit" class="auth-btn" id="register" name="register">Registruj se</button>
            <span id="registerErr" style="color: red"><?php echo $regErr?></span>
            <p class="auth-switch">Već imas nalog? <a href="login.php">Prijavi se</a></p>
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