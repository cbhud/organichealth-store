<?php
session_start();
require '../utils/connection.php';

// Samo za admina
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 1. Ukupni Prihodi i Narudžbine (Sve neotkazane)
$sql_totals = "SELECT SUM(total) as revenue, COUNT(order_id) as total_orders FROM orders WHERE status != 'otkazano'";
$res_totals = $konekcija->query($sql_totals);
$row_totals = $res_totals->fetch_assoc();
$total_revenue = $row_totals['revenue'] ?? 0;
$total_orders = $row_totals['total_orders'] ?? 0;
$avg_order = $total_orders > 0 ? (float)($total_revenue / $total_orders) : 0;

// 2. Po mesecima (Zadnjih 6 meseci)
$sql_monthly = "SELECT YEAR(order_date) as y, MONTH(order_date) as m, SUM(total) as rev, COUNT(order_id) as cnt FROM orders WHERE status != 'otkazano' GROUP BY YEAR(order_date), MONTH(order_date) ORDER BY y DESC, m DESC LIMIT 6";
$res_monthly = $konekcija->query($sql_monthly);

// 3. Po godinama
$sql_yearly = "SELECT YEAR(order_date) as y, SUM(total) as rev, COUNT(order_id) as cnt FROM orders WHERE status != 'otkazano' GROUP BY YEAR(order_date) ORDER BY y DESC LIMIT 5";
$res_yearly = $konekcija->query($sql_yearly);

// 4. Najprodavaniji proizvodi
$sql_products = "SELECT p.name, SUM(oi.quantity * oi.unit_price) as rev, SUM(oi.quantity) as qty FROM order_items oi JOIN product p ON oi.product_id = p.product_id JOIN orders o ON oi.order_id = o.order_id WHERE o.status != 'otkazano' GROUP BY p.product_id ORDER BY rev DESC LIMIT 5";
$res_products = $konekcija->query($sql_products);

// 5. Najbolji kupci
$sql_customers = "SELECT u.first_name, u.last_name, u.email, COUNT(o.order_id) as cnt, SUM(o.total) as rev FROM users u JOIN orders o ON u.user_id = o.user_id WHERE o.status != 'otkazano' GROUP BY u.user_id ORDER BY rev DESC LIMIT 5";
$res_customers = $konekcija->query($sql_customers);

function getMonthName($m) {
    $months = ["Januar", "Februar", "Mart", "April", "Maj", "Jun", "Jul", "Avgust", "Septembar", "Oktobar", "Novembar", "Decembar"];
    return $months[$m - 1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prihodi i Izvještaji | Admin Panel</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/adminpanel.css">
    <link rel="stylesheet" href="../css/revenue.css">
    <link rel="icon" type="image/jpg" href="../slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <a href="../index.php"><img src="../slike/logo.jpg" alt=""></a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="../index.php">Početna</a></li>
                    <li><a href="../products.php">Proizvodi</a></li>
                    <li><a href="../misc/about.php">O nama</a></li>
                    <li><a href="../misc/contact.php">Kontakt</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="../account.php"><i class='fas fa-user'></i></a>
                <a href="../cart.php"><i class='fa-solid fa-cart-shopping'></i></a>
                <a href="adminpanel.php"><i class='fas fa-clipboard-list'></i></a>
                <a href="../utils/logout.php"><i class='fa-solid fa-arrow-right-from-bracket'></i></a>
            </div>
        </div>
    </header>
    
    <main>
        <div class="container">
            <h1>Admin Panel</h1>
            <div class="admin-nav">
                <a href="adminpanel.php">Sve narudžbine</a>
                <a href="revenue.php" class="active">Prihodi i izvještaji</a>
                <a href="create_product.php">Dodaj proizvod</a>
                <a href="create_category.php">Dodaj kategoriju</a>
            </div>

            <div class="revenue-dashboard">
                <div class="metric-cards">
                    <div class="metric-card">
                        <h3>Ukupan Prihod</h3>
                        <div class="value"><?php echo number_format($total_revenue, 2); ?> €</div>
                    </div>
                    <div class="metric-card">
                        <h3>Ukupno Narudžbina</h3>
                        <div class="value"><?php echo $total_orders; ?></div>
                    </div>
                    <div class="metric-card">
                        <h3>Prosječna Vrijednost</h3>
                        <div class="value"><?php echo number_format($avg_order, 2); ?> €</div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    
                    <div class="dashboard-panel">
                        <h2>Prihodi po Mjesecima</h2>
                        <?php if($res_monthly && $res_monthly->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mjesec</th>
                                    <th>Broj prodaja</th>
                                    <th>Prihod</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = $res_monthly->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo getMonthName($r['m']) . ' ' . $r['y']; ?></td>
                                    <td><?php echo $r['cnt']; ?></td>
                                    <td><?php echo number_format($r['rev'], 2); ?> €</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p class="empty-state">Nema podataka.</p>
                        <?php endif; ?>
                    </div>

                    <div class="dashboard-panel">
                        <h2>Prihodi po Godinama</h2>
                        <?php if($res_yearly && $res_yearly->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Godina</th>
                                    <th>Broj prodaja</th>
                                    <th>Prihod</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = $res_yearly->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $r['y']; ?></td>
                                    <td><?php echo $r['cnt']; ?></td>
                                    <td><?php echo number_format($r['rev'], 2); ?> €</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p class="empty-state">Nema podataka.</p>
                        <?php endif; ?>
                    </div>

                    <div class="dashboard-panel">
                        <h2>Najprodavaniji Proizvodi</h2>
                        <?php if($res_products && $res_products->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Proizvod</th>
                                    <th>Prodate Količine</th>
                                    <th>Prihod</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = $res_products->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['name']); ?></td>
                                    <td><?php echo $r['qty']; ?> kom</td>
                                    <td><?php echo number_format($r['rev'], 2); ?> €</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p class="empty-state">Nema podataka o proizvodima.</p>
                        <?php endif; ?>
                    </div>

                    <div class="dashboard-panel">
                        <h2>Najbolji Kupci</h2>
                        <?php if($res_customers && $res_customers->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Kupac</th>
                                    <th>Broj Narudžbina</th>
                                    <th>Ukupna Potrošnja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($r = $res_customers->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['first_name'] . ' ' . $r['last_name']); ?></td>
                                    <td><?php echo $r['cnt']; ?></td>
                                    <td><?php echo number_format($r['rev'], 2); ?> €</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                            <p class="empty-state">Nema podataka o kupcima.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container footer-content">
            <div class="footer-left">
                <p>&copy; 2025 OrganicHealth CG</p>
            </div>
            <div class="footer-right">
                <span class="footer-location"><i class="fas fa-map-marker-alt"></i> Rozaje, Crna Gora</span>
                <span class="footer-social">
                    <a href="https://www.instagram.com/organichealthcg" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/p/Organic-Health-CG-61553907063139/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                </span>
            </div>
        </div>
    </footer>
</body>
</html>
