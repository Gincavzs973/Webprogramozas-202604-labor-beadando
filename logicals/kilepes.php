<?php
// A kilépő felhasználó adatainak átmentése a megjelenítéshez
$adatok = $_SESSION;

// Munkamenet változók törlése
unset($_SESSION['csn']);
unset($_SESSION['un']);
unset($_SESSION['login']);

// Teljes munkamenet megsemmisítése
session_destroy();
?>