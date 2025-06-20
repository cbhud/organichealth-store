<?php
session_start();
require 'utils/connection.php';
//odaberi 3 najnovija proizvoda
$sql = "SELECT * FROM product ORDER BY date_created DESC LIMIT 3";
$result = $konekcija->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!--    AJAX IMPORT KAKO BI RADILO ASYNC SLANJE-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        let flag;
        <?php
        //flag za role da proveri da li je korisnik ulogovan
        //prije nego doda u korpu
        if (isset($_SESSION['role'])) {
            echo 'flag = true;';
        } else {
            echo 'flag = false;';
        }
        ?>
        function fetchData(productId){
            if(!flag){
                alert('Morate biti ulogovani');
                return;
            }else {
            $.ajax({
                type: "POST",
                url: "utils/add_to_cart.php",
                data: {
                    product_id: productId,
                },
                success: function(data){
                    showCartPopup();
                }
            });
        }}
    </script>
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
                <li><a href="index.php" class="active-nav">Početna</a></li>
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
    <h1 class="section-title">Izdvajamo iz ponude</h1>
    <div class="container products-grid">
        <?php
        if ($result->num_rows > 0) {
            //ucitavanje proizvoda
            while ($row = $result->fetch_assoc()) {
                $productUrl = "product.php?id=" . $row['product_id'];
                echo "<div class='product-card'>";
                echo "<a href='$productUrl'>";
                echo "<img src='$row[img_url]' alt='[slika]'>";
                echo "</a>";
                echo "<a href='$productUrl'>";
                echo "<h3>$row[name]</h3>";
                echo "</a>";
                echo "<a href='$productUrl'>";
                echo "<p>$row[description]</p>";
                echo "</a>";
                echo "<span class='price'>$row[price]€</span>";
                echo "<button type='button' class='add-to-cart' onclick='fetchData(" . $row['product_id'] . ")'>Dodaj u korpu <span class='fas fa-cart-plus'></span></button>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <div class="all-products-btn-wrapper">
        <a href="products.php" class="all-products-btn">
            Pogledaj sve proizvode <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</main>
<footer>
    <div class="container footer-content">
        <div class="footer-left">
            <p>&copy;2025 OrganicHealth CG</p>
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
<!--POPUP KADA SE DODA U KORPU KAO MODALNI WINDOW UGL CSS ELEMENTI BACGROUND SIVA PROVIDNA I NA KLIK KROZ JS DA SE ZATVORI
    SLIKA CHECKMARK GIF SA INTERNETA
-->
<script src="js/popup.js"></script>
</body>
</html>