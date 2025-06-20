<?php
session_start();
require 'connection.php';

if (empty($_SESSION['id'])) {
    echo "X";
    exit;
}

$user_id = $_SESSION['id'];

// UPDATE ORDER
if (isset($_POST['action']) && $_POST['action'] === 'save_order') {
    updateOrder($user_id);
    exit;
}

// REMOVE ITEM
if (isset($_POST['action']) && $_POST['action'] === 'remove_item') {
    removeOrderItem($user_id);
    exit;
}

// CANCEL ORDER
if (isset($_POST['action']) && $_POST['action'] === 'cancel_order') {
    cancelOrder($user_id);
    exit;
}

echo "X";
exit;

function updateOrder($user_id) {
    global $konekcija;
    if (empty($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
        echo "X";
        exit;
    }

    $order_id = $_POST['order_id'];

    //provjera da li pripada korisniku narudzba ili je admin
    $sql = "SELECT user_id, status FROM Orders WHERE order_id = '$order_id'";
    $result = $konekcija->query($sql);
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($_SESSION['role'] !== 'admin' && $row['user_id'] != $user_id) {
        echo "X";
        exit;
    }

    }
    else{
        echo "X";
        exit;
    }

    $address = ($_POST['address']);
    $city = ($_POST['city']);
    $note = ($_POST['note']);

    if (strlen($address) < 6) {
        echo "X";
        exit;
    }
    if (strlen($city) < 2) {
        echo "X";
        exit;
    }
    if (!empty($note) && strlen($note) > 300) {
        echo "X";
        exit;
    }

    if ($_SESSION['role'] === 'admin' && isset($_POST['status']) && !empty($_POST['status'])) {
        $allow_statuses = ['u obradi', 'poslato', 'otkazano'];
        $status = trim($_POST['status']);
        if (!in_array($status, $allow_statuses)) {
            echo "X";
            exit;
        }
        $stmt = $konekcija->prepare("UPDATE Orders SET address = ?, city = ?, note = ?, status = ? WHERE order_id = ?");
        $stmt->bind_param("ssssi", $address, $city, $note, $status, $order_id);
    } else {
        //korisnik moze da mijenja narudzbu samo ako je status idalje u obradi
        if ($row['status'] !== 'u obradi') {
            echo "X";
            exit;
        }
        $stmt = $konekcija->prepare("UPDATE Orders SET address = ?, city = ?, note = ? WHERE order_id = ?");
        $stmt->bind_param("sssi", $address, $city, $note, $order_id);
    }

    if (!$stmt->execute()) {
        $stmt->close();
        echo "X";
        exit;
    }
    $stmt->close();

    echo "OK";
    exit;
}

function removeOrderItem($user_id) {
    global $konekcija;

    if (empty($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
        echo "X";
        exit;
    }
    if (empty($_POST['order_item_id']) || !is_numeric($_POST['order_item_id'])) {
        echo "X";
        exit;
    }
    $order_id = $_POST['order_id'];
    $order_item_id = $_POST['order_item_id'];

    //provjera da li pripada korisniku narudzba ili je admin
    $sql = "SELECT user_id, status FROM Orders WHERE order_id = '$order_id'";
    $result = $konekcija->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($_SESSION['role'] !== 'admin' && $row['user_id'] != $user_id) {
            echo "X";
            exit;
        }

    }
    else{
        echo "X";
        exit;
    }

    if ($row['status'] !== 'u obradi') {
        echo "X";
        exit;
    }

    $stmt = $konekcija->prepare("DELETE FROM Order_Items WHERE order_item_id = ? AND order_id = ?");
    $stmt->bind_param("ii", $order_item_id, $order_id);
    if (!$stmt->execute()) {
        $stmt->close();
        echo "X";
        exit;
    }
    $stmt->close();

    $stmt = $konekcija->prepare("SELECT SUM(quantity * unit_price) AS total FROM Order_Items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($new_total);
    $stmt->fetch();
    $stmt->close();

    $stmt = $konekcija->prepare("UPDATE Orders SET total = ? WHERE order_id = ?");
    $stmt->bind_param("di", $new_total, $order_id);
    $stmt->execute();
    $stmt->close();

    echo "OK";
    exit;
}

function cancelOrder($konekcija, $user_id) {
    if (empty($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
        echo "X";
        exit;
    }
    $order_id = intval($_POST['order_id']);

    //provjera da li pripada korisniku narudzba ili je admin
    $sql = "SELECT user_id, status FROM Orders WHERE order_id = '$order_id'";
    $result = $konekcija->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($_SESSION['role'] !== 'admin' && $row['user_id'] != $user_id) {
            echo "X";
            exit;
        }

    }
    else{
        echo "X";
        exit;
    }

    if ($row['status'] !== 'u obradi') {
        echo "X";
        exit;
    }

    $stmt = $konekcija->prepare("UPDATE Orders SET status='otkazano' WHERE order_id=?");
    $stmt->bind_param("i", $order_id);
    if (!$stmt->execute()) {
        $stmt->close();
        echo "X";
        exit;
    }
    $stmt->close();

    echo "OK";
    exit;
}
?>