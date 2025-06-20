<?php
session_start();
if (empty($_GET['id'])){
    header('Location: index.php');
    exit;
}
require 'utils/connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM Product WHERE product_id = '$id'";
$result = $konekcija->query($sql);
if ($result->num_rows < 1){
    header('Location: index.php');
    exit;
}
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?> | Organic Health CG</title>
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        function redirectToEdit(productId){
            window.location.href = "edit_product.php?id="+productId;
        }

        function deleteProduct(productId){
            $.ajax({
                type: "POST",
                url: "utils/deleteproduct.php",
                data: {
                    productId: productId
                },
                success: function(data){
                    alert(data);
                    window.location.href = "products.php";
                }
            });
        }

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
            let quantity = document.getElementById('quantity').value;
            $.ajax({
                type: "POST",
                url: "utils/add_to_cart.php",
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                success: function(){
                    showCartPopup();
                }
            });
        }

        function kupi(productId){
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
                let quantity = document.getElementById('quantity').value;
                $.ajax({
                    type: "POST",
                    url: "utils/add_to_cart.php",
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(){
                        location.href = "checkout.php";
                    }
                });
            }

            function changeQty(num) {
                let qtyInput = document.getElementById('quantity');
                let current = parseInt(qtyInput.value, 10);
                current += num;
                if (current < 1) current = 1;
                qtyInput.value = current;
            }
        </script>
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
    <section class="container product-view">
        <div class="product-view-img">
            <img src="<?php echo $product["img_url"] ?>" alt="">
        </div>
        <div class="product-view-details">
            <h1><?php echo $product["name"] ?></h1>
            <p class="product-view-description"><?php echo $product["description"] ?></p>
            <div class="product-view-price-row">
                <span class="product-view-price"><?php echo $product["price"] ?> €</span>
            </div>
            <label for="quantity" class="product-view-quantity-label">Količina:</label>
            <div class="product-view-quantity">
                <button type="button" class="quantity-btn" onclick="changeQty(-1)">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" disabled>
                <button type="button" class="quantity-btn" onclick="changeQty(1)">+</button>
            </div>
            <div class="product-view-actions">
                <button type="submit" class="buy-now-btn" name="buy_now" onclick="kupi(<?php echo $product['product_id'] ?>)">Kupi odmah</button>
                <button type="button" class="add-to-cart-btn add-to-cart" onclick="addToCart(<?php echo $product['product_id'] ?>)"><i class="fas fa-cart-plus"></i></button>
                <?php if (isset($_SESSION['role']) && $_SESSION["role"] == "admin") { ?>
                    <button type="button" class="edit-btn" onclick="redirectToEdit(<?php echo $product['product_id']?>)">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button type="button" class="delete-btn" onclick="deleteProduct(<?php echo $product['product_id']; ?>)">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                <?php } ?>
            </div>
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
<script src="js/popup.js"></script>
</body>
</html>