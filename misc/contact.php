<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt | Organic Health CG</title>
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<header>
    <div class="container header-content">
        <div class="logo">
            <a href="../index.php">
                <img src="/web-shop/slike/logo.jpg" alt="">
            </a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Početna</a></li>
                <li><a href="../products.php">Proizvodi</a></li>
                <li><a href="about.php">O nama</a></li>
                <li><a href="contact.php" class="active-nav">Kontakt</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <?php
            if (empty($_SESSION["role"])) {
                echo "<a href='../login.php'><i class='fas fa-user'></i></a>";
            } else if ($_SESSION["role"] == "user"){
                echo "<a href='../account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='../cart.php'><i class='fa-solid fa-cart-shopping'></i></i></a>";
                echo "<a href='../utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            }else if ($_SESSION["role"] == "admin") {
                echo "<a href='../account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='../cart.php'><i class='fa-solid fa-cart-shopping'></i></i></a>";
                echo "<a href='../adminpanel.php'><i class='fas fa-clipboard-list'></i></a>";
                echo "<a href='../utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            }
            ?>
        </div>
    </div>
</header>
<main>
    <section class="contact-hero">
        <div class="container">
            <h1 class="section-title">Kontaktirajte nas</h1>
            <p class="contact-hero-text">
                Imate pitanje? Tu smo za vas! Javite nam se putem forme, društvenih mreža ili nas posjetite na adresi.
            </p>
            <br>
        </div>
    </section>
    <div class="container contact-content">
        <section class="contact-details">
            <div class="contact-info">
                <h2>Kontakt podaci</h2>
                <ul>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Rozaje, Crna Gora</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:info@organichealthcg.com">info@organichealthcg.com</a>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:+38267000000">+382 67 000 000</a>
                    </li>
                    <li>
                        <i class="fab fa-instagram"></i>
                        <a href="https://www.instagram.com/organichealthcg" target="_blank">@organichealthcg</a>
                    </li>
                    <li>
                        <i class="fab fa-facebook-f"></i>
                        <a href="https://www.facebook.com/p/Organic-Health-CG-61553907063139/" target="_blank">Organic Health CG</a>
                    </li>
                </ul>
            </div>
            <div class="contact-form-box">
                <h2>Pošaljite poruku</h2>
                <form class="contact-form" method="post" action="#">
                    <div class="form-group">
                        <label for="name">Ime i prezime</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email adresa</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Poruka</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="contact-btn">Pošalji</button>
                </form>
            </div>
        </section>
        <section class="contact-map">
            <h2>Gdje se nalazimo?</h2>
            <div class="map-responsive">
                <iframe
                    src="https://www.google.com/maps?q=Rozaje,+Crna+Gora&output=embed"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
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