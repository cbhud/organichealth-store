<?php
session_start();
require 'utils/connection.php';
if (empty($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

$user_name = '';
$user_phone = '';
if (isset($_SESSION['role']) && $_SESSION['role'] != '' && isset($_SESSION['id'])) {
    $sql = "SELECT first_name, last_name, phone_number, email FROM users WHERE user_id = " . $_SESSION['id'];
    $result = $konekcija->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_name = $row['first_name'] . " " . $row['last_name'];
        $user_phone = $row['phone_number'];
    }
}

$cart = array();
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
}

$total = 0;

$cities = array(
    'Andrijevica',
    'Bar',
    'Berane',
    'Bijelo Polje',
    'Budva',
    'Cetinje',
    'Danilovgrad',
    'Gusinje',
    'Herceg Novi',
    'Kolašin',
    'Kotor',
    'Mojkovac',
    'Nikšić',
    'Petnjica',
    'Plav',
    'Pljevlja',
    'Plužine',
    'Podgorica',
    'Rožaje',
    'Šavnik',
    'Tivat',
    'Ulcinj',
    'Žabljak'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/popup.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
            <?php
               if ($_SESSION["role"] == "user") {
                    echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                    echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
                }
                else if($_SESSION["role"] == "admin") {
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
        <h1 class="section-title">Zavrsetak narudzbine</h1>
        <?php
        if (count($cart) == 0) {
            echo '<div class="empty-cart" style="text-align:center;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 2rem; color: #888;"></i><br>
                Vaša korpa je prazna.
            </div>';
        } else {
            echo '<div class="checkout-container">';
            // SUMMARY
            echo '<div class="checkout-summary">';
            echo '<h2>Sazetak korpe</h2>';
            echo '<div class="checkout-list">';
            foreach ($cart as $product_id => $quantity) {
                $sql = "SELECT name, price FROM Product WHERE product_id = $product_id LIMIT 1";
                $result = $konekcija->query($sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $item_total = $row['price'] * $quantity;
                    echo '<div class="checkout-list-item">';
                    echo '<span>' . $row['name'] . ' ×' . $quantity . '</span>';
                    echo '<span>' . $item_total . ' €</span>';
                    echo '</div>';
                    $item_total = $row['price'] * $quantity;
                    $total += $item_total;
                }
            }
            echo '</div>';
            echo '<div class="checkout-total-row">';
            echo '<span>Ukupno:</span>';
            echo '<span>' . $total . ' €</span>';
            echo '</div>';
            echo '<br>';
            echo '<div style="margin: 15px 0 20px 0;">';
            echo '<a href="cart.php" class="btn" style="padding: 8px 18px; background:#eee; border:1px solid #ccc; text-decoration:none; border-radius:4px; color:#333;"><i class="fas fa-arrow-left"></i> Nazad na korpu</a>';
            echo '</div>';
            echo '</div>';

            echo '<form class="checkout-form">';
            echo '<h2>Podaci za dostavu</h2>';
            echo '<label for="name">Ime i prezime</label>';
            echo '<input type="text" id="name" name="name" value="' . $user_name . '" onkeyup="validateName()">';
            echo '<span id="nameErr"></span>';
            echo '<label for="phone">Telefon</label>';
            echo '<input type="tel" id="phone" name="phone" value="'. $user_phone .'" onkeyup="validatePhone()">';
            echo '<span id="phoneErr"></span>';
            echo '<label for="address">Adresa</label>';
            echo '<input type="text" id="address" name="address" onkeyup="validateAddress();">';
            echo '<span id="addressErr"></span>';
            echo '<label for="city">Grad</label>';
            echo '<select id="city" name="city" onchange="validateCity();">';
//            LISTA GRADOVA U OPTCIJE
            echo '<option value="">Odaberite grad</option>';
            for ($i = 0; $i < count($cities); $i++) {
                echo '<option value="' . $cities[$i] . '">' . $cities[$i] . '</option>';
            }
            echo '</select>';
            echo '<span id="cityErr"></span>';
            echo '<label for="note">Napomena</label>';
            echo '<input type="text" id="note" name="note" onkeyup="validateNote();">';
            echo '<span id="noteErr"></span>';
            echo '<button type="button" name="naruci" onclick="checkValidation()" class="checkout-btn">Potvrdi narudžbu</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
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
<script src="/web-shop/js/popup2.js"></script>
<script>
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phoneRegex = /^\d{9}$/;

    function validateName() {
        let name = document.getElementById("name").value.trim();
        let span = document.getElementById("nameErr");
        if (name.length < 3) {
            span.textContent = "Ime i prezime moraju imati najmanje 3 karaktera.";
            span.style.color = "red";
            return false;
        }
        span.textContent = "";
        return true;
    }

    function validatePhone() {
        let phone = document.getElementById("phone").value.trim();
        let span = document.getElementById("phoneErr");
        if (!phoneRegex.test(phone)) {
            span.textContent = "Telefon mora imati tačno 9 cifara.";
            span.style.color = "red";
            return false;
        }
        span.textContent = "";
        return true;
    }
    function validateAddress() {
        let address = document.getElementById("address").value.trim();
        let span = document.getElementById("addressErr");
        if (address.length < 6) {
            span.textContent = "Adresa mora imati najmanje 6 karaktera.";
            span.style.color = "red";
            return false;
        }
        span.textContent = "";
        return true;
    }
    function validateCity() {
        let city = document.getElementById("city").value;
        let span = document.getElementById("cityErr");
        if (city === "") {
            span.textContent = "Morate odabrati grad.";
            span.style.color = "red";
            return false;
        }
        span.textContent = "";
        return true;
    }
    function validateNote() {
        let note = document.getElementById("note").value;
        let span = document.getElementById("noteErr");
        if (note.length > 250) {
            span.textContent = "Napomena može imati najviše 250 karaktera.";
            span.style.color = "red";
            return false;
        }
        span.textContent = "";
        return true;
    }
    function checkValidation() {
        let validName = validateName();
        let validPhone = validatePhone();
        let validAddress = validateAddress();
        let validCity = validateCity();
        let validNote = validateNote();
        if (validName && validPhone && validAddress && validCity && validNote){
            fetchData();
        }else {
            alert("nije dobar unos!")
        }
        return validName && validPhone && validAddress && validCity && validNote;
    }

    function fetchData(){
        $.ajax({
            type: "POST",
            url: "utils/order_submit.php",
            data: {
                sent: true,
                name: document.getElementById("name").value,
                phone: document.getElementById("phone").value,
                address: document.getElementById("address").value,
                city: document.getElementById("city").value,
                note: document.getElementById("note").value,
            },
            success: function(data){
                if (data === "OK"){
                showCartPopup2();
                }else {
                    alert(data)
                }
            }
        });
    }

</script>
</body>
</html>