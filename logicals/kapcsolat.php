<?php
$eredmeny = '';

if (isset($_POST['kuld'])) {
    $nev = trim($_POST['nev']);
    $szoveg = trim($_POST['szoveg']);
    
    // Szerveroldali validáció (Labor követelmény: PHP ellenőrzés is kötelező)
    if (empty($nev)) {
        $eredmeny = "Hiba: A név megadása kötelező!";
    } elseif (empty($szoveg) || strlen($szoveg) < 10) {
        $eredmeny = "Hiba: Az üzenet szövegének legalább 10 karakter hosszúnak kell lennie!";
    } else {
        // Ha a validáció sikeres, mentés az adatbázisba
        try {
            // Kapcsolódás a Nethely adatbázishoz
            $dbh = new PDO('mysql:host=localhost;dbname=csapatrecept_db', 'csapatrecept_db', 'Titkostanulas,09',
                            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8 COLLATE utf8_general_ci');
            
            // Adatok beszúrása az uzenetek táblába (id auto-increment, datum a szerver aktuális ideje)
            $sqlInsert = "INSERT INTO uzenetek (nev, szoveg, datum) VALUES (:nev, :szoveg, NOW())";
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(':nev' => $nev, ':szoveg' => $szoveg)); 
            
            if($stmt->rowCount()) {
                $eredmeny = "Köszönjük! Az üzenetét sikeresen elmentettük.";
            } else {
                $eredmeny = "Hiba történt az üzenet mentése során.";
            }
        } catch (PDOException $e) {
            $eredmeny = "Adatbázis hiba: " . $e->getMessage();
        }
    }
}
?>