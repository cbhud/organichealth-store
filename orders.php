<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require 'utils/connection.php';

$user_id = $_SESSION['id'];

$sql = "SELECT o.order_id, o.order_date, o.status, o.total FROM Orders o WHERE o.user_id = $user_id ORDER BY o.order_date DESC";
$result = $konekcija->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moje Narudžbine | Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            if (empty($_SESSION["role"])) {
                echo "<a href='login.php'><i class='fas fa-user'></i></a>";
                echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
            } else if ($_SESSION["role"] == "user"){
                echo "<a href='account.php'><i class='fas fa-user'></i></a>";
                echo "<a href='cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                echo "<a href='utils/logout.php'><i class='fa-solid fa-arrow-right-from-bracket'></i></a>";
            } else if ($_SESSION["role"] == "admin") {
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
        <h1>Moj Nalog</h1>
        <div class="account-nav">
            <a href="account.php" class="">Detalji naloga</a>
            <a href="orders.php" class="active">Moje narudžbine</a>
        </div>
        <div class="account-orders">
            <h2>Moje narudžbine</h2>
            <?php
            if ($result->num_rows === 0){
                echo '<p>Nemate narudžbina.</p>';
            } else {
                ?>
                <table>
                    <thead>
                    <tr>
                        <th>ID narudžbine</th>
                        <th>Datum</th>
                        <th>Status</th>
                        <th>Ukupno</th>
                        <th>Detalji</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['total'] . " €</td>";
                        echo "<td><a href='order.php?id=" . $row['order_id'] . "' class='btn-details' title='Prikaži detalje'><i class='fa fa-eye'></i></a></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            <?php } ?>
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