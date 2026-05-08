<?php
$uzenet = array();
$MAPPA = './images/';

// Képfeltöltés feldolgozása (csak bejelentkezett felhasználóknak)
if (isset($_SESSION['login']) && isset($_POST['kuld'])) {
    if (isset($_FILES['fajl']) && $_FILES['fajl']['error'] == 0) {
        $fajlnev = $_FILES['fajl']['name'];
        $tipus = $_FILES['fajl']['type'];
        
        // Validáció: csak kép (JPG vagy PNG)
        if ($tipus == 'image/jpeg' || $tipus == 'image/png') {
            $vegso_hely = $MAPPA . basename($fajlnev);
            if (move_uploaded_file($_FILES['fajl']['tmp_name'], $vegso_hely)) {
                $uzenet[] = "Sikeres feltöltés: " . $fajlnev;
            } else {
                $uzenet[] = "Hiba a fájl mozgatásakor.";
            }
        } else {
            $uzenet[] = "Nem megfelelő fájltípus! Csak JPG és PNG engedélyezett.";
        }
    } else {
        $uzenet[] = "Hiba a feltöltés során vagy nem választottál fájlt!";
    }
}

// Képek beolvasása a galériához
$kepek = array();
$olvaso = opendir($MAPPA);
while (($fajl = readdir($olvaso)) !== false) {
    if (is_file($MAPPA . $fajl)) {
        $vege = strtolower(pathinfo($fajl, PATHINFO_EXTENSION));
        
        // Logikai szűrő: Csak képek, KIVÉVE a logo.png
        if (($vege == 'jpg' || $vege == 'jpeg' || $vege == 'png') && $fajl !== 'logo.png') {
            $kepek[] = $fajl;
        }
    }
}
closedir($olvaso);
?>