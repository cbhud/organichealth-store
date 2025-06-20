<?php
session_start();
require 'utils/connection.php';

// Samo za admina
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$sql = "SELECT o.order_id, o.order_date, o.status, o.total, u.first_name, u.last_name, u.email, u.phone_number 
        FROM Orders o 
        JOIN Users u ON o.user_id = u.user_id 
        ORDER BY o.order_date DESC";

$result = $konekcija->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/adminpanel.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>
        function fetchData(){
            $.ajax({
                type: "POST",
                url: "utils/admin_report.php",
                data: {
                    report: "true",
                },
                success: function(data){
                    alert(data);
                }
            });
        }
    </script>
</head>
<body>
<header>
    <div class="container header-content">
        <div class="logo">
            <a href="index.php"><img src="/web-shop/slike/logo.jpg" alt=""></a>
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
            <a href="account.php"><i class='fas fa-user'></i></a>
            <a href="cart.php"><i class='fa-solid fa-cart-shopping'></i></a>
            <a href="adminpanel.php"><i class='fas fa-clipboard-list'></i></a>
            <a href="utils/logout.php"><i class='fa-solid fa-arrow-right-from-bracket'></i></a>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <h1>Admin Panel</h1>
        <div class="admin-nav">
            <a href="adminpanel.php" class="active">Sve narudžbine</a>
            <a href="#" onclick="fetchData()">Mjesečni izveštaj</a>
            <a href="create_product.php">Dodaj proizvod</a>
            <a href="create_category.php">Dodaj kategoriju</a>
        </div>
        <div class="admin-orders">
            <h2>Sve narudžbine</h2>
            <?php
            if ($result->num_rows == 0) {
                echo "<p>Nema narudžbina.</p>";
            } else {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID narudžbine</th>
                                <th>Datum</th>
                                <th>Status</th>
                                <th>Kupac</th>
                                <th>Email</th>
                                <th>Telefon</th>
                                <th>Ukupno</th>
                                <th>Detalji</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . ($row['order_id']) . "</td>";
                    echo "<td>" . ($row['order_date']) . "</td>";
                    echo "<td>" . ($row['status']) . "</td>";
                    echo "<td>" . ($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                    echo "<td>" . ($row['email']) . "</td>";
                    echo "<td>" . ($row['phone_number']) . "</td>";
                    echo "<td>" . $row['total'] . " €</td>";
                    echo "<td><a href='order.php?id=" . $row['order_id'] . "' class='btn-details' title='Prikaži detalje'><i class='fa fa-eye'></i></a></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            }
            ?>
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
