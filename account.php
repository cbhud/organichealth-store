<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}
require 'utils/connection.php';

$id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE user_id = '$id'";
$result = $konekcija->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
extract($row);

function validateInput($fname, $lname, $email, $phone, $password)
{
    global $regErr;

    $fname = trim($fname);
    $lname = trim($lname);
    $email = trim($email);
    $phone = trim($phone);
    $password = trim($password);

    if (strlen($fname) < 2 || strlen($lname) < 2) {
        $regErr = "Ime i prezime moraju imati najmanje 2 karaktera.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $regErr = "Email adresa nije validna!";
        return false;
    }

    if (!preg_match('/^\d{9}$/', $phone)) {
        $regErr = "Broj telefona mora imati tačno 9 cifara.";
        return false;
    }

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $regErr = "Lozinka mora imati najmanje 8 karaktera.";
            return false;
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $regErr = "Lozinka mora sadržati slova i brojeve.";
            return false;
        }
    }

    return true;
}


if (isset($_POST['edit']) && $_POST['edit'] == "Yes") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!validateInput($fname, $lname, $email, $phone, $password)) {
        echo $regErr;
        exit;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $konekcija->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, password = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $fname, $lname, $email, $phone, $hashedPassword, $id);
    } else {
        $stmt = $konekcija->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $fname, $lname, $email, $phone, $id);
    }

    if ($stmt->execute()) {
        echo "Podaci su uspješno ažurirani.";
    } else {
        echo "Došlo je do greške prilikom ažuriranja.";
    }

    $stmt->close();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moj Nalog | Organic Health CG</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="icon" type="image/jpg" href="/web-shop/slike/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/web-shop/js/account.js"></script>
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
    <div class="container">
        <h1>Moj Nalog</h1>
        <div class="account-nav">
            <a href="account.php" class="active">Detalji Naloga</a>
            <a href="orders.php" class="">Moje narudžbine</a>
        </div>
        <div class="account-details">
            <span id="msg"></span>
            <form id="accountForm">
                <label for="first_name">Ime</label>
                <input type="text" id="fname" onkeyup="checkValidation()" value="<?php echo $first_name?>">
                <span id="fnameErr"></span>
                <label for="last_name">Prezime</label>
                <input type="text" id="lname" onkeyup="checkValidation()" value="<?php echo $last_name?>">
                <span id="lnameErr"></span>
                <label for="email">Email</label>
                <input type="email" id="email" onkeyup="checkValidation()" value="<?php echo $email?>">
                <span id="mailErr"></span>

                <label for="phone_number">Telefon</label>
                <input type="text" id="phone" onkeyup="checkValidation()" value="<?php echo $phone_number?>">
                <span id="phoneErr"></span>

                <label for="password">Nova lozinka (Ako ne mijenjate ostavite prazno)</label>
                <input type="password" id="password" onkeyup="checkValidation()">
                <span id="passErr"></span>

                <button type="button" id="update" onclick="editData()">Sacuvaj izmene</button>
            </form>
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