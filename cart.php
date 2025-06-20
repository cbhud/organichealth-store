<?php
session_start();
if (empty($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}
require 'utils/connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$cart = $_SESSION['cart'];
$total = 0;

//brisanje iz korpe
if (isset($_POST['remove_id'])) {
    $remove_id = $_POST['remove_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    echo "OK";
    exit;
}

//update kolicine u sesiji korpe
if (isset($_POST['update_id']) && isset($_POST['update_qty'])) {
    $update_id = $_POST['update_id'];
    $update_qty = $_POST['update_qty'];
    if ($update_qty < 1) {
        $update_qty = 1;
    }
    if (isset($_SESSION['cart'][$update_id])) {
        $_SESSION['cart'][$update_id] = $update_qty;
    }
    echo "OK";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vaša korpa | Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        function changeQty(productId, change) {
            let qtyInput = document.getElementById('qty-' + productId);
            let currentQty = parseInt(qtyInput.value, 10);
            if (isNaN(currentQty)) {
                currentQty = 1;
            }
            let newQty = currentQty + change;
            if (newQty < 1) {
                newQty = 1;
            }
            qtyInput.value = newQty;

            let parent = qtyInput.parentNode.parentNode;
            let priceDivs = parent.getElementsByClassName('cart-product-price');
            let price = 0;

            if (priceDivs.length > 0) {
                price = parseFloat(priceDivs[0].getAttribute('data-price'));
            }

            let itemTotalDiv = document.getElementById('item-total-' + productId);
            let itemTotal = (price * newQty);
            itemTotalDiv.innerHTML = itemTotal + ' €';

            updateCartTotal();

            $.ajax({
                url: "cart.php",
                type: "POST",
                data: {
                    update_id: productId, update_qty: newQty
                },
                success: function(resp){}
            });
        }

        function removeFromCart(productId) {
            let itemDiv = document.getElementById('cart-item-' + productId);
            if (itemDiv) {
                itemDiv.parentNode.removeChild(itemDiv);
            }
            updateCartTotal();
            $.ajax({
                url: "cart.php",
                type: "POST",
                data: {remove_id: productId},

                success: function(){
                    if (document.getElementsByClassName('cart-item').length == 0) {
                        let container = document.getElementsByClassName('cart-container')[0];
                        container.innerHTML = '<div class="empty-cart"><i class="fa-solid fa-cart-shopping" style="font-size: 2rem; color: #888;"></i><br>Vaša korpa je prazna.</div>';

                    }
                }
            });
        }

        function updateCartTotal() {
            let items = document.getElementsByClassName('cart-item');
            let sum = 0;
            for (let i = 0; i < items.length; i++) {

                let qtyInputs = items[i].getElementsByClassName('cart-qty-input');
                let priceDivs = items[i].getElementsByClassName('cart-product-price');

                if (qtyInputs.length > 0 && priceDivs.length > 0) {
                    let qty = parseInt(qtyInputs[0].value, 10);
                    let price = parseFloat(priceDivs[0].getAttribute('data-price'));
                    sum += qty * price;
                }
            }

            let totalDiv = document.getElementById('cart-total');

            if (totalDiv) {
                totalDiv.innerHTML = sum.toFixed(2);
            }
        }
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
                <li><a href="index.php">Početna</a></li>
                <li><a href="products.php">Proizvodi</a></li>
                <li><a href="misc/about.php">O nama</a></li>
                <li><a href="misc/contact.php">Kontakt</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <?php
            if (!isset($_SESSION["role"])) {
                echo "<a href='login.php'><i class='fas fa-user'></i></a>";
            } else {
                if ($_SESSION["role"] == "user") {
                    echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                    echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
                }
                if ($_SESSION["role"] == "admin") {
                    echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                    echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<a href='adminpanel.php'><i class='fas fa-clipboard-list'></i></a>";
                    echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
                }
            }
            ?>
        </div>
    </div>
</header>
<main>

    <div class="container cart-container">
        <h1 class="section-title">Vaša korpa</h1>
        <?php
        if (count($cart) == 0) {
            echo '<div class="empty-cart">
                <i class="fa-solid fa-cart-shopping" style="font-size: 2rem; color: #888;"></i><br>
                Vaša korpa je prazna.
            </div>';
        } else {
            echo '<div class="cart-items">';
            foreach ($cart as $pid => $qty) {
                $query = "SELECT product_id, name, price, img_url FROM Product WHERE product_id = $pid LIMIT 1";
                $result = $konekcija->query($query);
                if ($result && $row = $result->fetch_assoc()) {
                    $item_total = $row['price'] * $qty;
                    $total += $item_total;
                    echo '<div class="cart-item" id="cart-item-' . $pid . '">';
                    echo '<div class="cart-product-info">';
                    echo '<img src="' . ($row['img_url']) . '" alt="' . ($row['name']) . '" class="cart-product-img">';
                    echo '<div class="cart-product-details">';
                    echo '<div class="cart-product-name">' . ($row['name']) . '</div>';
                    echo '<div class="cart-product-price" data-price="' . $row['price'] . '">' . $row['price'] . ' €</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="cart-item-controls">';
                    echo '<button type="button" class="qty-btn" onclick="changeQty(' . $pid . ', -1)">-</button>';
                    echo '<input type="number" min="1" id="qty-' . $pid . '" value="' . $qty . '" class="cart-qty-input" disabled>';
                    echo '<button type="button" class="qty-btn" onclick="changeQty(' . $pid . ', 1)">+</button>';
                    echo '<button type="button" class="btn remove-btn" onclick="removeFromCart(' . $pid . ')"><i class="fas fa-trash"></i> Ukloni</button>';
                    echo '</div>';
                    echo '<div class="cart-item-total" id="item-total-' . $pid . '">' . $item_total . ' €</div>';
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '<div class="cart-summary">';
            echo '<strong>Ukupno:</strong> <span id="cart-total">' . number_format($total, 2) . '</span> €';
            echo '</div>';
            echo '<div class="cart-actions">';
            echo '<a href="products.php" class="btn continue-btn"><i class="fas fa-arrow-left"></i> Nastavi kupovinu</a>';
            echo '<a href="checkout.php" class="btn checkout-btn">Naruči <i class="fas fa-arrow-right"></i></a>';
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
</body>
</html>