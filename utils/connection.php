<?php
$username = "sql7823607";
$password = "qbaigeGiB1";
$host = "sql7.freesqldatabase.com";
$dbname = "sql7823607";


$konekcija = new mysqli($host, $username, $password, $dbname);


if ($konekcija->connect_error) {
    echo "Konekcija NIJE USPJESNA PROVJERI CONNECTION.PHP!!!: " . $konekcija->connect_error;
}
