<?php
session_start();
require 'utils/connection.php';

$sql = "SELECT * FROM product ORDER BY date_created DESC";
$result = $konekcija->query($sql);

$sql2 = "SELECT * FROM categories";
$result2 = $konekcija->query($sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvodi | Organic Health CG</title>
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        function addToCart(productId){
            let flag;
            <?php
            if (isset($_SESSION['role'])) {
                echo 'flag = true;';
            } else {
                echo 'flag = false;';
            }?>

                if(!flag){
                    alert('Morate biti ulogovani');
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "utils/add_to_cart.php",
                    data: {
                        product_id: productId,
                    },
                    success: function(){
                        showCartPopup();
                    }
                });
            }

            // Ova funkcija se poziva kada se stranica ucita
            function initAll() {
                // Kada korisnik pise u polje za pretragu
                let searchInput = document.getElementById("search");
                if (searchInput) {
                    //na input ce se searchovati za producte
                    searchInput.addEventListener("input", searchProducts);
                }

                // korisnik klikne van pretrage ili sugestija zatvorice se
                document.addEventListener("mousedown", function(e) {
                    let suggestions = document.getElementById("search-suggestions");
                    let search = document.getElementById("search");
                    if (suggestions && e.target !== suggestions && e.target !== search) {
                        suggestions.style.display = "none";
                    }
                });

                let category = document.getElementById("category");
                let sort = document.getElementById("sort");
                //dodavanje event listenera i funkcije za elemente
                if (category) category.addEventListener("change", filterProducts);
                if (sort) sort.addEventListener("change", filterProducts);

                // Kada korisnik klikne na sugestiju iz pretrage
                document.addEventListener("mousedown", function(e) {
                    //kada ima vise elemenata i child elemenata itema closest omogucava da odaberemo
                    //bira stariji element iz hijerarhije tj closest
                    const suggestionItem = e.target.closest(".suggestion-item");
                    if (suggestionItem && !suggestionItem.classList.contains("no-result")) {
                        let prodName = suggestionItem.querySelector(".name").textContent;
                        document.getElementById("search").value = prodName;
                        document.getElementById("search-suggestions").style.display = "none";
                        //za redirect kupimo id
                        let productId = suggestionItem.getAttribute("data-id");
                        window.location.href = "product.php?id=" + productId;
                    }
                });

            }

            // AJAX pretraga proizvoda
            function searchProducts() {
                let hint = document.getElementById("search").value.trim();
                let suggestions = document.getElementById("search-suggestions");
                if (hint.length === 0) {
                    suggestions.style.display = "none";
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: 'utils/productshint.php',
                    data: { hint: hint },
                    success: function(response) {
                        //trim nam brise whitespacove sa pocetka i kraja
                        //trim zato sto ako vraca empty string da znamo da je prazno
                        if (response.trim().length > 0) {
                            suggestions.innerHTML = response;
                            suggestions.style.display = "block";
                        } else {
                            suggestions.style.display = "none";
                        }
                    }
                });
            }

            // AJAX filtriranje proizvoda po cijeni i kategoriji
            function filterProducts() {
            //kupimo value iz elemente
                let category = document.getElementById("category").value;
                let sort = document.getElementById("sort").value;

                $.ajax({
                    type: 'GET',
                    url: 'utils/filter_products.php',
                    //saljemo podatke ajaxom
                    data: { category: category, sort: sort },
                    success: function(response) {
                        document.querySelector(".products-grid").innerHTML = response;
                    }
                });
            }


        </script>
    </head>
    <body onload="initAll()">
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
                    <li><a href="products.php" class="active-nav">Proizvodi</a></li>
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
    <h1 class="section-title">Naša ponuda proizvoda</h1>
    <div class="container">
        <form class="main-search-form">
            <input type="text" placeholder="Pretraži proizvode..." name="search" id="search">
            <button type="button"><i class="fas fa-search"></i> Pretraga</button>
            <div id="search-suggestions" class="search-suggestions"></div>
        </form>

        <div class="products-layout">
            <aside class="filter-sidebar">
                <form class="filter-form">
                    <h3>Filtriraj proizvode</h3>
                    <div class="filter-group">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category">
                            <?php
                            echo "<option value='all'>Sve kategorije</option>";
                            while ($row2 = $result2->fetch_assoc()) {
                                echo "<option value='" . $row2["category_id"] . "'>" . $row2["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="sort">Sortiraj po cijeni</label>
                        <select id="sort" name="sort">
                            <option value="default">Odaberi</option>
                            <option value="price-asc">Cijena rastuce</option>
                            <option value="price-desc">Cijena opadajuce</option>
                        </select>
                    </div>
                </form>
            </aside>
            <section class="products-section">
                <div class="products-grid">
                    <?php
                    if ($result->num_rows > 0) {
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
                            echo "<button type='button' class='add-to-cart' onclick='addToCart(" . $row['product_id'] . ")'>Dodaj u korpu <span class='fas fa-cart-plus'></span></button>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </section>
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
<script src="js/popup.js"></script>
</body>
</html>