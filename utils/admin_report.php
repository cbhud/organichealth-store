<?php
session_start();
require 'connection.php';

if (isset($_SESSION['id']) && $_SESSION['role'] === 'admin') {

    if (isset($_POST['report'])) {

        $sql = "
            SELECT u.first_name, u.last_name, u.email, u.phone_number, COUNT(o.order_id) AS broj_narudzbi
            FROM Users u
            LEFT JOIN Orders o ON u.user_id = o.user_id
            GROUP BY u.user_id
            ORDER BY u.last_name, u.first_name
        ";

        $result = $konekcija->query($sql);

        if ($result) {

            $file = fopen("izvestaj.csv", "a+");

            fwrite($file, "|--IME--|--PREZIME--|--EMAIL--|--TELEFON--|--BRNARUDZBI--| \n");
            while ($row = $result->fetch_assoc()) {
                $red = $row['first_name'] . "," . $row['last_name'] . "," . $row['email'] . "," . $row['phone_number'] . "," . $row['broj_narudzbi'] . "\n";
                fwrite($file, $red);
            }

            fclose($file);
            echo "Izvjestaj generisan!";
        } else {
            echo "Greška u upitu.";
        }
    }
}
?>
