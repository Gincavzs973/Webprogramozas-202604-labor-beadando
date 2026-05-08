<?php
$eredmeny = '';

if (isset($_POST['nev']) && isset($_POST['szoveg'])) {
    $nev = trim($_POST['nev']);
    $szoveg = trim($_POST['szoveg']);
    
    // Szerveroldali validáció
    if (empty($nev)) {
        $eredmeny = "Hiba: A név megadása kötelező!";
    } elseif (empty($szoveg) || strlen($szoveg) < 10) {
        $eredmeny = "Hiba: Az üzenetnek legalább 10 karakternek kell lennie!";
    } else {
        try {
            // Adatbázis kapcsolódás (A te adataiddal)
            $dbh = new PDO('mysql:host=localhost;dbname=csapatrecept_db', 'csapatrecept_db', 'Titkostanulas,09',
                            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8 COLLATE utf8_general_ci');
            
            $sqlInsert = "INSERT INTO uzenetek (nev, szoveg, datum) VALUES (:nev, :szoveg, NOW())";
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(':nev' => $nev, ':szoveg' => $szoveg)); 
            
            if($stmt->rowCount()) {
                $eredmeny = "Köszönjük! Az üzenetét sikeresen elmentettük.";
            } else {
                $eredmeny = "Hiba történt a mentés során.";
            }
        } catch (PDOException $e) {
            $eredmeny = "Adatbázis hiba: " . $e->getMessage();
        }
    }

    // HA AJAX kérés érkezett, csak az eredményt küldjük vissza és kilépünk
    if (isset($_POST['ajax'])) {
        echo $eredmeny;
        exit; 
    }
}
?>