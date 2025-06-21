<?php
session_start();

if(empty($_SESSION['role'])){
    echo "Morate biti ulogovani!";
    return;
}

//korpa se realizuje kao niz product_idjeva
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


//asocijativni niz product_id kljuc koji ukazuje na kolicinu tog itema
// tj product -> quantity
//provjera ako je dodato u korpi
if (isset($_POST['product_id'])) {
    //provjera da li je broj
    $product_id = (int)$_POST['product_id'];

    //ukoliko je setovao i quantity povecaj kolicinu za taj broj
    if (isset($_POST['quantity'])) {
        $quantity = (int)$_POST['quantity'];
        if ($quantity < 1) {
            $quantity = 1;
        }

    //ako nema quantity default ce biti 1
    } else {
        $quantity = 1;
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}


?>