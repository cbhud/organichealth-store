<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nama | Organic Health CG</title>
    <link rel="stylesheet" href="../css/about.css">
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
                <li><a href="about.php" class="active-nav">O nama</a></li>
                <li><a href="contact.php">Kontakt</a></li>
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
    <section class="about-story">
        <div class="container">
            <div>
                <h2>O nama</h2>
                <p class="about-hero-text">
                    <strong>Organic Health CG</strong> - mjesto gde zdravlje, priroda i inovacija idu ruku pod ruku. Naša misija je da podržimo vaše zdravlje, vitalnost i svakodnevni balans uz proizvode vrhunskog kvaliteta, pažljivo odabrane iz bogatstva prirode.
                </p>
            </div>
        </div>
    </section>
    <section class="about-story">
        <div class="container">
            <h2>Priča o brendu</h2>
            <p>
                Inspirisani tradicijom i naukom, verujemo da su prirodni sastojci ključ za dugoročnu energiju i harmoniju tela i uma. Naša ponuda obuhvata suplemente, prirodnu kozmetiku i specijalizovane proizvode za zdravu ishranu, pažljivo birane prema najvišim standardima kvaliteta i bezbjednosti.
            </p>
            <p>
                U saradnji sa renomiranim proizvođačima i stručnjacima iz oblasti wellnessa, stalno obogaćujemo naš asortiman inovativnim formulama i sertifikovanim proizvodima. Naš cilj je da vam budemo pouzdan partner na putu ka zdravijem životu, bilo da želite podržati imunitet, povećati energiju, ili negovati prirodnu lepotu.
            </p>
        </div>
    </section>
    <section class="about-values">
        <div class="container">
            <h2>Zašto Organic Health CG?</h2>
            <ul class="about-values-list">
                <li>
                    <i class="fas fa-leaf"></i>
                    <span><strong>Prirodni sastojci</strong>  <br>Samo najčistiji ekstrakti i prirodni derivati.</span>
                </li>
                <li>
                    <i class="fas fa-flask"></i>
                    <span><strong>Proveren kvalitet</strong>  Sertifikovani i laboratorijski testirani proizvodi.</span>
                </li>
                <li>
                    <i class="fas fa-users"></i>
                    <span><strong>Podrška zajednici</strong>  Savjeti, edukacija i podrška na svakom koraku.</span>
                </li>
                <li>
                    <i class="fas fa-globe-europe"></i>
                    <span><strong>Međunarodni standardi</strong>  Proizvodi priznatih brendova i inovativne formulacije.</span>
                </li>
            </ul>
        </div>
    </section>
    <section class="about-mission">
        <div class="container">
            <h2>Naša misija</h2>
            <p>
                Naša misija je jednostavna, omogućiti svakome pristup kvalitetnim proizvodima koji doprinose zdravlju, vitalnosti i ravnoteži. Posvećeni smo transparentnosti, brizi o kupcima i stalnom unapređenju. Vaše poverenje nam je na prvom mestu!
            </p>
        </div>
    </section>
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
