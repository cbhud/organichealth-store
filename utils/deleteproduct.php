<?php
session_start();

if(!isset($_SESSION['role']) && !isset($_SESSION['email'])){
    header('location:login.php');
    exit();
}

if($_SESSION['role'] != 'admin'){
    header('location:login.php');
    exit();
}

require 'connection.php';

if($_POST['productId']){
    if(!isset($_POST['productId'])){
        header('location:index.php');
        exit();
    }

$id = $_POST['productId'];

    //BRISANJE KASKADNO KAKO BISMO IZBJEGLI PROBLEME
    //PRVO JE POTREBNO OBRISATI SVE IZ ORDER ITEMA
    $statement = $konekcija->prepare("DELETE FROM order_items WHERE product_id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
    $statement->close();

// Tek onda BRISEMO PROIZVOD
    $statement = $konekcija->prepare("DELETE FROM product WHERE product_id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
    $statement->close();
echo "sUCCESS";
}