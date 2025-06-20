<?php
require 'connection.php';

if (!isset($_GET['hint'])) {
exit;
}

$hint = trim($_GET["hint"]);

if ($hint !== "") {
    $sql = "
        SELECT product_id, name, price, img_url
        FROM Product
        WHERE name LIKE '%$hint%'
        ORDER BY date_created DESC
        LIMIT 10
    ";
    $result = $konekcija->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="suggestion-item" data-id="' . $row["product_id"] . '">';
            echo '<img src="' . $row["img_url"] . '" alt="' . $row["name"] . '">';
            echo '<div class="suggestion-details">';
            echo '<span class="name">' . $row["name"] . '</span>';
            echo '<span class="price">' . $row["price"] . ' €</span>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="suggestion-item">Nema proizvoda za"<b>' . $hint . '</b>"</div>';
    }

}
$konekcija->close();
?>