<?php
// Mivel ezt az oldalt csak bejelentkezett felhasználók láthatják, beépítünk egy extra védelmet
if (!isset($_SESSION['login'])) {
    header("Location: .");
    exit;
}

$uzenetek_lista = array();
$lekkerdezes_hiba = '';

try {
    // Kapcsolódás a Nethely adatbázishoz
    $dbh = new PDO('mysql:host=localhost;dbname=csapatrecept_db', 'csapatrecept_db', 'Titkostanulas,09',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_general_ci');
    
    // Üzenetek lekérdezése dátum szerint csökkenő sorrendben (legújabb legelöl)
    $sqlSelect = "SELECT nev, szoveg, datum FROM uzenetek ORDER BY datum DESC";
    $sth = $dbh->query($sqlSelect);
    $uzenetek_lista = $sth->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $lekkerdezes_hiba = "Hiba az üzenetek lekérdezésekor: " . $e->getMessage();
}
?>