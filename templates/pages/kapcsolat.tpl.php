<h2>Kapcsolat</h2>
<p>Kérdése van a receptjeinkkel kapcsolatban? Írjon nekünk!</p>

<div id="ajax-valasz" style="display:none; padding: 15px; margin-bottom: 20px; border-left: 5px solid #0066cc; background: #e6f7ff;">
    <strong id="valasz-szoveg"></strong>
</div>

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
    event.preventDefault(); // Megállítja a hagyományos oldalfrissítéssel járó küldést

    let hiba = '';
    let nev = document.getElementById('nev').value.trim();
    let szoveg = document.getElementById('szoveg').value.trim();
    let valaszDiv = document.getElementById('ajax-valasz');
    let valaszSzoveg = document.getElementById('valasz-szoveg');

    // 1. Kliensoldali Validáció
    if (nev === '') {
        hiba += '- A név megadása kötelező!\n';
    }
    if (szoveg === '') {
        hiba += '- Az üzenet szövege nem lehet üres!\n';
    } else if (szoveg.length < 10) {
        hiba += '- Az üzenetnek legalább 10 karakter hosszúnak kell lennie!\n';
    }

    if (hiba !== '') {
        alert('Javítsa a hibákat:\n' + hiba);
        return false;
    }

    // 2. AJAX (Fetch) küldés
    let formData = new FormData(this);
    formData.append('ajax', 'true'); // Jelezzük a PHP-nek, hogy ez AJAX kérés

    fetch('kapcsolat', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Megjelenítjük a választ és ürítjük az űrlapot
        valaszSzoveg.innerText = data;
        valaszDiv.style.display = 'block';
        if(data.includes("sikeresen")) {
            document.getElementById('szoveg').value = ''; 
        }
    })
    .catch(error => {
        console.error('Hiba:', error);
        alert('Hiba történt a küldés során.');
    });
};
</script>