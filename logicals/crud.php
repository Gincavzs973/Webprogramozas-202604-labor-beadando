<?php
// Biztonsági ellenőrzés: A CRUD műveleteket csak bejelentkezett felhasználók érhetik el
if (!isset($_SESSION['login'])) {
    header("Location: belepes");
    exit;
}

$uzenet = '';
$kategoriak = array();
$etelek = array();

try {
    // Kapcsolódás a Nethely adatbázishoz
    $dbh = new PDO('mysql:host=localhost;dbname=csapatrecept_db', 'csapatrecept_db', 'Titkostanulas,09',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_general_ci');

    // --- 1. C.R.U.D. MŰVELETEK FELDOLGOZÁSA (ÍRÁS/MÓDOSÍTÁS/TÖRLÉS) ---
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // CREATE (Létrehozás)
        if ($action == 'create' && !empty($_POST['nev']) && !empty($_POST['kategoriaid']) && !empty($_POST['felirdatum'])) {
            $elsodatum = !empty($_POST['elsodatum']) ? $_POST['elsodatum'] : null;
            $sql = "INSERT INTO etel (nev, kategoriaid, felirdatum, elsodatum) VALUES (:nev, :kategoriaid, :felirdatum, :elsodatum)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':nev' => $_POST['nev'],
                ':kategoriaid' => $_POST['kategoriaid'],
                ':felirdatum' => $_POST['felirdatum'],
                ':elsodatum' => $elsodatum
            ));
            $uzenet = "Új étel sikeresen hozzáadva!";
        }
        // UPDATE (Módosítás)
        elseif ($action == 'update' && !empty($_POST['id']) && !empty($_POST['nev']) && !empty($_POST['kategoriaid']) && !empty($_POST['felirdatum'])) {
            $elsodatum = !empty($_POST['elsodatum']) ? $_POST['elsodatum'] : null;
            $sql = "UPDATE etel SET nev = :nev, kategoriaid = :kategoriaid, felirdatum = :felirdatum, elsodatum = :elsodatum WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':nev' => $_POST['nev'],
                ':kategoriaid' => $_POST['kategoriaid'],
                ':felirdatum' => $_POST['felirdatum'],
                ':elsodatum' => $elsodatum,
                ':id' => $_POST['id']
            ));
            $uzenet = "Az étel adatai sikeresen módosítva!";
        }
        // DELETE (Törlés)
        elseif ($action == 'delete' && !empty($_POST['id'])) {
            $sql = "DELETE FROM etel WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':id' => $_POST['id']));
            $uzenet = "Az étel sikeresen törölve!";
        } else {
            $uzenet = "Hiba: Hiányzó adatok a művelethez!";
        }
    }

    // --- 2. ADATOK LEKÉRDEZÉSE A MEGJELENÍTÉSHEZ (OLVASÁS) ---

    // Kategóriák lekérdezése (A legördülő választómezőkhöz)
    $stmtCat = $dbh->query("SELECT id, nev FROM kategoria ORDER BY nev");
    $kategoriak = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

    // Ételek lekérdezése (A táblázathoz, a kategória nevével kiegészítve)
    $stmtEtel = $dbh->query("
        SELECT e.id, e.nev, e.kategoriaid, k.nev AS kategoria_nev, e.felirdatum, e.elsodatum 
        FROM etel e 
        LEFT JOIN kategoria k ON e.kategoriaid = k.id 
        ORDER BY e.id DESC
    ");
    $etelek = $stmtEtel->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $uzenet = "Adatbázis hiba: " . $e->getMessage();
}
?>