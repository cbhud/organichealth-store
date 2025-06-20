<?php
session_start();
require 'utils/connection.php';

// Restrict access to admin only
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$result = $konekcija->query("SELECT category_id, name FROM Categories ORDER BY name ASC");

if (isset($_POST['ajax'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $category_id = $_POST['category_id'];

    if (strlen($name) < 2) {
        echo "Naziv prekratak";
        exit;
    }
    if (strlen($name) > 120) {
        echo "Naziv predugacak";
        exit;
    }
    if (!is_numeric($price)) {
        echo "Cijena nije broj";
        exit;
    }
    if ($price < 0) {
        echo "Cijena manja od nule";
        exit;
    }
    if (!is_numeric($stock)) {
        echo "Kolicina nije broj";
        exit;
    }
    if ($stock < 0) {
        echo "Kolicina manja od nule";
        exit;
    }
    if (strlen($description) < 5) {
        echo "Opis prekratak";
        exit;
    }
    if (strlen($description) > 800) {
        echo "Opis predugacak";
        exit;
    }
    if ($category_id < 1) {
        echo "Kategorija nije izabrana";
        exit;
    }

    if (!empty($image_url) && strlen($image_url) > 255) {
        echo "URL slike je predug.";
        exit;
    }

    $stmt = $konekcija->prepare("INSERT INTO Product (name, price, stock, description, img_url, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sdissi', $name, $price, $stock, $description, $image_url, $category_id);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Greška pri kreiranju proizvoda.";
    }

    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kreiraj proizvod | Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="css/edit_product.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/web-shop/js/createproduct.js"></script>
</head>
<body>
<header>
    <div class="container header-content">
        <a class="logo" href="index.php"><img src="/web-shop/slike/logo.jpg" alt="Logo"></a>
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
            } elseif ($_SESSION["role"] === "user") {
                echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            } elseif ($_SESSION["role"] === "admin") {
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
        <div class="create-product-form">
            <h2>Kreiraj novi proizvod</h2>
            <div class="status-msg" id="product-msg"></div>
            <form id="create-product" >
                <label for="name">Naziv proizvoda</label>
                <input type="text" class="name" name="name" id="name" maxlength="120">

                <label for="category_id">Kategorija</label>
                <select class="category_id" name="category_id" id="category_id">
                    <option value="">-- Izaberi kategoriju --</option>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="price">Cena (€)</label>
                <input type="number" step="0.01" class="price" name="price" id="price" min="0" max="10000">

                <label for="stock">Na stanju</label>
                <input type="number" class="stock" name="stock" id="stock" min="0" max="100000">

                <label for="description">Opis</label>
                <textarea class="description" name="description" id="description" maxlength="800"></textarea>

                <label for="image_url">Slika (URL)</label>
                <input type="text" class="image_url" name="image_url" id="image_url" maxlength="300" placeholder="Npr: /web-shop/slike/proizvod.jpg">

                <button type="button" onclick="validateProductForm()">Kreiraj proizvod</button>
            </form>
        </div>
    </div>
</main>
<footer>
    <div class="container footer-content">
        <div class="footer-left">
            <p>&copy; 2025 OrganicHealth CG</p>
        </div>
        <div class="footer-right">
            <span class="footer-location"><i class="fas fa-map-marker-alt"></i> Rožaje, Crna Gora</span>
            <span class="footer-social">
                <a href="https://www.instagram.com/organichealthcg" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/p/Organic-Health-CG-61553907063139/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            </span>
        </div>
    </div>
</footer>
</body>
</html>