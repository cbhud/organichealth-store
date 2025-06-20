<?php
session_start();
require 'connection.php';

if (isset($_POST['sent']) && $_POST['sent'] == true) {
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        echo "X";
        exit;
    }
    makeCheckout($konekcija);
}

function makeCheckout($konekcija) {
//kupimo sta je poslato AJAxom
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $note = $_POST['note'];

    //VALIDACIJA INPUTA
    if (strlen($name) < 3) {
        echo 'X';
        exit;
    }

    if (strlen($address) < 6) {
        echo 'X';
        exit;
    }

    if (!preg_match('/^\d{9}$/', $phone)) {
        echo 'X';
        exit;
    }


        $user_id = $_SESSION['id'];

    if (!empty($note) && strlen($note) > 250) {
        echo 'X';
        exit;
    }

    //uzimamo cart
    $cart = $_SESSION['cart'];

    //pravimo novi niz kako bi mogli da pokupimo cijene iz baze
    //asocijativni niz za cijene tj productid->cijena
    $productPrices = array();
    $total = 0;

    foreach ($cart as $productId => $quantity) {
        // kupimo cijene iz baze
        $sql = "SELECT price FROM Product WHERE product_id = $productId";
        $result = $konekcija->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            $price = $row['price'];
            //dodajemo u asocijativni niz productid=>cijena
            $productPrices[$productId] = $price;
            $total += $price * $quantity;
        } else {
            //ako proizvod ne postoji setujemo cijenu na 0
            $productPrices[$productId] = 0;
        }
    }

    $status = 'u obradi';

    $stmt = $konekcija->prepare("INSERT INTO Orders (user_id, status, total, address, city, note) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isdsss', $user_id, $status, $total, $address, $city, $note);
        if (!$stmt->execute()) {
            echo "X";
            exit;
    }

    $order_id = $stmt->insert_id;
    $stmt->close();

    //ubacujemo order iteme u bazu
    $stmt_items = $konekcija->prepare("INSERT INTO Order_Items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $product_id => $quantity) {
        if (isset($productPrices[$product_id])) {
            $unit_price = $productPrices[$product_id];
        } else {
            $unit_price = 0;
        }

        $stmt_items->bind_param("iiid", $order_id, $product_id, $quantity, $unit_price);
        $stmt_items->execute();
    }

    $stmt_items->close();

    unset($_SESSION['cart']);

    echo "OK";
    exit;
}

?>