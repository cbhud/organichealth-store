<?php
require 'connection.php';

$category = $_GET['category'] ?? 'all';
$sort = $_GET['sort'] ?? 'default';

$sql = "SELECT * FROM product";

if ($category != 'all') {
    $sql .= " WHERE category_id = ?";
}

switch ($sort) {
    case 'price-asc':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price-desc':
        $sql .= " ORDER BY price DESC";
        break;
    default:
        $sql .= " ORDER BY date_created DESC";
        break;
}

$stmt = $konekcija->prepare($sql);

if ($category != 'all') {
    $stmt->bind_param("i", $category);
}
$stmt->execute();
$result = $stmt->get_result();

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
} else {
    echo "<div class='empty-cart'>Nema proizvoda za izabrane filtere.</div>";
}
$konekcija->close();
?>