<?php
$username = "root";
$password = "";
$host = "localhost";
$dbname = "webshop";


$konekcija = new mysqli($host, $username, $password, $dbname);


if ($konekcija->connect_error) {
    echo "Konekcija NIJE USPJESNA PROVJERI CONNECTION.PHP!!!: " . $konekcija->connect_error;
}
