<?php
session_start();
require 'utils/connection.php';

if (empty($_SESSION['id']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
if (isset($_POST['name'])) {
    $name = trim($_POST['name']);

    //php validacija unosa
    if (!preg_match('/^.{2,64}$/u', $name)) {
        echo "Naziv mora imati izmedju 2 i 64 slova.";
        exit;
    }

    $sql = "SELECT 1 FROM Categories WHERE name = '$name'";
    $result = $konekcija->query($sql);
    if ($result->num_rows > 0) {
        $stmt->close();
        echo "Kategorija već postoji.";
        exit;
    }

    $stmt = $konekcija->prepare("INSERT INTO Categories (name) VALUES (?)");
    $stmt->bind_param('s', $name);
    if ($stmt->execute()) {
        $stmt->close();
        echo "OK";
        exit;
    } else {
        $stmt->close();
        echo "Greška pri upisu u bazu.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kreiraj kategoriju | Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<header>

    <div class="container header-content">
        <a class="logo" href="index.php">
            <img src="/web-shop/slike/logo.jpg" alt="Logo">
        </a>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="products.php">Proizvodi</a></li>
                <li><a href="misc/about.php">O nama</a></li>
                <li><a href="misc/contact.php">Kontakt</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <?php
            if (empty($_SESSION["role"])) {
                echo "<a href='login.php'><i class='fas fa-user'></i></a>";
            } else if ($_SESSION["role"] == "user"){
                echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            }else if ($_SESSION["role"] == "admin") {
                echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                echo "<a href='adminpanel.php'><i class='fas fa-clipboard-list'></i></a>";
                echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            }
            ?>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <div class="create-product-form" style="max-width:340px;margin:36px auto 28px auto;">
            <h2 style="margin-bottom:14px; color:#26712f;">Kreiraj novu kategoriju</h2>
            <label for="cat-name" style="font-weight:500;">Naziv kategorije</label>
            <input type="text" id="cat-name" maxlength="64" style="width:100%;padding:9px 12px; border:1px solid #d1d5db; border-radius:6px; margin-bottom:12px;">
            <button id="cat-create-btn" style="width:100%;padding:11px 0; background:#197b30; color:#fff; border:none; border-radius:8px; font-size:1.05em; font-weight:600; cursor:pointer;">Kreiraj kategoriju</button>
        </div>
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
<script>
    function validateCategoryName(name) {
        if (name.length < 2 || name.length > 64) {
            alert('Naziv mora imati bar 2 i najviše 64 slova.');
            return false;
        }
        return true;
    }
    $('#cat-create-btn').on('click', function(e){
        e.preventDefault();
        let name = $('#cat-name').val().trim();
        if (!validateCategoryName(name)) return;
        $.ajax({
            type: 'POST',
            url: 'create_category.php',
            data: {name: name},
            success: function(resp) {
                if(resp === 'OK') {
                    alert('Uspjesno ste napravili kategoriju');
                    window.location.href = 'adminpanel.php';
                } else {
                    alert(resp);
                }
            },
            error: function() {
                alert('Greška u komunikaciji sa serverom!');
            }
        });
    });
</script>
</body>
</html>