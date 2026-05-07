<h2>Kapcsolat</h2>
<p>Kérdése van a receptjeinkkel kapcsolatban? Írjon nekünk!</p>

<?php if(isset($eredmeny) && $eredmeny !== '') { ?>
    <div style="background: #e6f7ff; padding: 15px; margin-bottom: 20px; border-left: 5px solid #0066cc;">
        <strong><?= $eredmeny ?></strong>
    </div>
<?php } ?>

<div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <form action="kapcsolat" method="post" id="kapcsolatForm" novalidate>
        
        <div style="margin-bottom: 15px;">
            <label for="nev">Név:</label><br>
            <input type="text" id="nev" name="nev" 
                   value="<?= isset($_SESSION['login']) ? $_SESSION['csn'].' '.$_SESSION['un'] : 'Vendég' ?>" 
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" 
                   <?= isset($_SESSION['login']) ? 'readonly' : '' ?>>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="szoveg">Üzenet szövege:</label><br>
            <textarea id="szoveg" name="szoveg" rows="6" 
                      style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
        </div>
        
        <input type="submit" name="kuld" value="Üzenet elküldése" 
               style="padding: 10px 20px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
    </form>
</div>

<script>
document.getElementById('kapcsolatForm').onsubmit = function(event) {
    let hiba = '';
    let nev = document.getElementById('nev').value.trim();
    let szoveg = document.getElementById('szoveg').value.trim();

    // Szabályok ellenőrzése
    if (nev === '') {
        hiba += '- A név megadása kötelező!\n';
    }
    if (szoveg === '') {
        hiba += '- Az üzenet szövege nem lehet üres!\n';
    } else if (szoveg.length < 10) {
        hiba += '- Az üzenetnek legalább 10 karakter hosszúnak kell lennie!\n';
    }

    // Ha van hiba, megállítjuk a küldést és jelezzük
    if (hiba !== '') {
        alert('Kérjük, javítsa a következő hibákat az elküldés előtt:\n\n' + hiba);
        event.preventDefault(); // Megakadályozza a PHP-hez való továbbítást
        return false;
    }
    
    // Ha nincs hiba, az űrlap elküldésre kerül
    return true;
};
</script>