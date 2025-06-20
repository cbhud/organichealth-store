<?php
session_start();
require 'utils/connection.php';

if (empty($_SESSION['id']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
}else{
    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM Product WHERE product_id = '$product_id'";
$result = $konekcija->query($sql);
if ($result->num_rows > 0) {
    $product= $result->fetch_assoc();
}
else{
    echo "Proizvod nije pronađen.";
    exit;
}

if (isset($_POST['ajax'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $category_id = $_POST['category_id'];

    if (strlen($name) < 2) {
        echo "Naziv mora imati najmanje 2 slova";
        exit;
    }

    if (strlen($name) > 120) {
        echo "Naziv ne smijee imati vise od 120 karaktera";
        exit;
    }

    if ($price === '') {
        echo "Cijena ne smije biti prazna";
        exit;
    }

    if (!is_numeric($price)) {
        echo "cijena mora biti broj";
        exit;
    }

    if ($price < 0) {
        echo "Cena mora biti broj veci od 0";
        exit;
    }

    if ($stock === '') {
        echo "Kolicina na stanju je obavezna";
        exit;
    }

    if (!is_numeric($stock)) {
        echo "Kolicina mora biti broj";
        exit;
    }

    if ($stock < 0) {
        echo "Na stanju mora biti broj veci od 0";
        exit;
    }

    if (strlen($description) < 5) {
        echo "Opis mora imati najmanje 5 karaktera.";
        exit;
    }

    if (strlen($description) > 250) {
        echo "Opis ne smije imati više od 250 karaktera.";
        exit;
    }

    if ($category_id < 1) {
        echo "Kategorija nije izabrana.";
        exit;
    }

    if ($image_url && strlen($image_url) > 255) {
        echo "URL slike je predugačak.";
        exit;
    }

    $stmt = $konekcija->prepare("UPDATE Product SET name=?, price=?, stock=?, description=?, img_url=?, category_id=? WHERE product_id=?");
    $stmt->bind_param('sdissii', $name, $price, $stock, $description, $image_url, $category_id, $product_id);
    if ($stmt->execute()) {
        $stmt->close();
        echo "OK";
        exit;
    } else {
        $stmt->close();
        echo "Greška pri ažuriranju proizvoda.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Izmeni proizvod | Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="css/edit_product.css">

    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/web-shop/js/editproduct.js"></script>
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
        <div class="create-product-form">
            <h2>Izmeni proizvod</h2>
            <div class="status-msg"></div>
            <form class="edit-product-form">
                <label for="name">Naziv proizvoda</label>
                <input type="text" class="name" name="name" id="name" value="<?php echo ($product['name']) ?>">

                <label for="category_id">Kategorija</label>
                <select class="category_id" name="category_id" id="category_id">
                    <option value="">-Odaberi kategoriju-</option>
                    <?php
                    $sql = "SELECT category_id, name FROM Categories";
                    $result = $konekcija->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['category_id'] . '"';
                            if ($product['category_id'] == $row['category_id']) {
                                echo ' selected';
                            }
                            echo '>' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="price">Cena (€)</label>
                <input type="number" step="0.01" class="price" name="price" id="price" min="0" max="10000" value="<?php echo $product['price'] ?>">

                <label for="stock">Na stanju</label>
                <input type="number" class="stock" name="stock" id="stock" min="0" max="100000" value="<?php echo $product['stock'] ?>">

                <label for="description">Opis</label>
                <textarea class="description" name="description" id="description" maxlength="800"><?php echo $product['description'] ?></textarea>

                <label for="image_url">Slika (URL)</label>
                <input type="text" class="image_url" name="image_url" id="image_url" maxlength="300" placeholder="Npr: /web-shop/slike/proizvod.jpg" value="<?php echo $product['img_url'] ?>">

                <button type="button" onclick="validateProductForm(<?php echo $product_id;?>)">Sacuvaj izmjene</button>
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