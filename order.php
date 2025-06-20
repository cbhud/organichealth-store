<?php
session_start();
require 'utils/connection.php';

if (empty($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['id'];

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Nije validan ID narudžbine.";
    exit;
}
$order_id = $_GET['id'];

$sql = "SELECT o.*, u.first_name, u.last_name, u.phone_number 
        FROM Orders o 
        LEFT JOIN Users u ON o.user_id = u.user_id 
        WHERE o.order_id = $order_id";
$order_result = $konekcija->query($sql);
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Narudžbina nije pronađena.";
    exit;
}

    $buyer_name = $order['first_name'] . ' ' . $order['last_name'];
    $buyer_phone = $order['phone_number'];

if ($_SESSION['role'] != 'admin' && $order['user_id'] != $user_id) {
    echo "Narudžbina ne pripada vama.";
    exit;
}

$sql = "
    SELECT oi.*, p.name 
    FROM Order_Items oi
    JOIN Product p ON oi.product_id = p.product_id 
    WHERE oi.order_id = $order_id
";
$items_result = $konekcija->query($sql);
$order_items = [];
while ($item = $items_result->fetch_assoc()) {
    $order_items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detalji narudžbine #<?php echo ($order_id) ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/web-shop/js/order.js"></script>
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
            if ($_SESSION["role"] == "user"){
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
    <div class="order-detail-box">
        <?php
        echo '<h2>Detalji narudzbine #' . $order_id . '</h2>';

        if ($_SESSION['role'] == 'admin') {
            echo '<div><strong>Status:</strong> ';
            echo '<select id="order-status-admin">';
            switch ($order['status']) {
                case 'u obradi':
                    echo '<option value="u obradi" selected>u obradi</option>';
                    echo '<option value="poslato">poslato</option>';
                    echo '<option value="otkazano">otkazano</option>';
                    break;
                case 'poslato':
                    echo '<option value="u obradi">u obradi</option>';
                    echo '<option value="poslato" selected>poslato</option>';
                    echo '<option value="otkazano">otkazano</option>';
                    break;
                case 'otkazano':
                    echo '<option value="u obradi">u obradi</option>';
                    echo '<option value="poslato">poslato</option>';
                    echo '<option value="otkazano" selected>otkazano</option>';
                    break;
                default:
                    echo '<option value="u obradi">u obradi</option>';
                    echo '<option value="poslato">poslato</option>';
                    echo '<option value="otkazano">otkazano</option>';
                    break;
            }
            echo '</select>';
            echo '</div>';
        } else {
            if ($order['status'] == "otkazano") {
                echo '<div><strong>Status:</strong> <span class="order-status-cancel">' . $order['status'] . '</span></div>';
            } else {
                echo '<div><strong>Status:</strong> <span class="order-status">' . $order['status'] . '</span></div>';
            }
        }
        echo '<div><strong>Ime i prezime:</strong> ' . $order['first_name'] . ' ' . $order['last_name'] . '</div>';
        echo '<div><strong>Telefon:</strong> <span id="display-phone">' . $order['phone_number'] . '</span></div>';
        echo '<div><strong>Adresa:</strong> <span id="display-address">' . $order['address'] . '</span></div>';
        echo '<div><strong>Grad:</strong> <span id="display-city">' . $order['city'] . '</span></div>';
        echo '<div><strong>Napomena:</strong> <span id="display-note">' . $order['note'] . '</span></div>';
        echo '<div><strong>Ukupno:</strong> <span id="order-total">' . $order['total'] . '</span> €</div>';
        echo '<div style="margin-top:12px"><strong>Stavke:</strong></div>';
        ?>
        <form class="order-form" method="post" autocomplete="off">
            <table class="order-items-table">
                <thead>
                <tr>
                    <th>Proizvod</th>
                    <th>Kolicina</th>
                    <th>Cijena/kom</th>
                    <th>Ukupno</th>
                    <?php
                    if ($order['status'] === 'u obradi') {
                        echo "<th>Obrisi</th>";
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                for ($i = 0; $i < count($order_items); $i++) {
                    $item = $order_items[$i];
                    echo '<tr data-order-item-id="' . $item['order_item_id'] . '">';
                    echo '<td>' . $item['name'] . '</td>';
                    echo '<td>' . $item['quantity'] . '</td>';
                    echo '<td>' . $item['unit_price'] . ' €</td>';
                    echo '<td>' . ($item['unit_price'] * $item['quantity']) . ' €</td>';

                    if ($order['status'] === 'u obradi' || $_SESSION['role'] === 'admin') {
                        echo '<td class="item-actions">';
                        echo '<button type="button" class="delete-btn" data-order-item-id="' . $item['order_item_id'] . '" onclick="removeOrderItem(this)"><i class="fa-solid fa-trash"></i></button>';
                        echo '</td>';
                    }

                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <?php
            if ($order['status'] === 'u obradi' || $_SESSION['role'] === 'admin') {

                echo '<label for="address">Adresa</label>';
                echo '<input type="text" id="address" name="address" value="' . $order['address'] . '" onkeyup="validateAddress()" autocomplete="off">';
                echo '<span id="addressErr"></span>';

                echo '<label for="city">Grad</label>';
                echo '<input type="text" id="city" name="city" value="' . $order['city'] . '" onkeyup="validateCity()" autocomplete="off">';
                echo '<span id="cityErr"></span>';

                echo '<label for="note">Napomena</label>';
                echo '<input type="text" id="note" name="note" value="' . $order['note'] . '" onkeyup="validateNote()" autocomplete="off">';
                echo '<span id="noteErr"></span>';
                echo '<div class="button-row">';
                echo '<button type="button" name="update" id="save-order-btn" onclick="saveOrder()">Sacuvaj</button>';
                echo '<button type="button" name="cancel" class="cancel-btn" id="cancel-order-btn" onclick="cancelOrder()">Otkazi narudžbinu</button>';
                echo '</div>';
            } elseif ($order['status'] === 'poslato' && $_SESSION['role'] != 'admin') {
                echo '<div style="margin-top:18px; color:#888;">Narudzbina je poslata. Promjene više nisu moguće.</div>';
            } elseif ($order['status'] === 'otkazano' && $_SESSION['role'] != 'admin') {
                echo '<div style="margin-top:18px; color:#ff0000;">Narudzbina je otkazana.</div>';
            }
            ?>
        </form>
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