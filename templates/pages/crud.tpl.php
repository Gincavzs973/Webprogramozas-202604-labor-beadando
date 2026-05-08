<h2>Ételek Kezelése (CRUD)</h2>

<?php if (!empty($uzenet)): ?>
    <div style="background: #e6f7ff; padding: 15px; border-left: 5px solid #0066cc; margin-bottom: 20px;">
        <strong><?= $uzenet ?></strong>
    </div>
<?php endif; ?>

<div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <h3 id="formCim">Új étel hozzáadása</h3>
    <form action="crud" method="post" id="crudForm">
        <input type="hidden" name="action" id="action" value="create">
        <input type="hidden" name="id" id="etel_id" value="">

        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1; min-width: 200px;">
                <label for="nev">Étel neve:</label><br>
                <input type="text" name="nev" id="nev" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="kategoriaid">Kategória:</label><br>
                <select name="kategoriaid" id="kategoriaid" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">Válasszon...</option>
                    <?php foreach($kategoriak as $kat): ?>
                        <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nev']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1; min-width: 200px;">
                <label for="felirdatum">Felírás dátuma:</label><br>
                <input type="date" name="felirdatum" id="felirdatum" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="elsodatum">Első elkészítés (opcionális):</label><br>
                <input type="date" name="elsodatum" id="elsodatum" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
        </div>

        <input type="submit" id="submitBtn" value="Hozzáadás" style="padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        <button type="button" onclick="resetForm()" style="padding: 10px 20px; background: #6c757d; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Mégse</button>
    </form>
</div>

<h3>Jelenlegi ételek listája</h3>
<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <thead style="background: #333; color: #fff;">
            <tr>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Név</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Kategória</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Felírva</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Elkészítve</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($etelek as $etel): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $etel['id'] ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;"><?= htmlspecialchars($etel['nev']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($etel['kategoria_nev']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $etel['felirdatum'] ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;"><?= $etel['elsodatum'] ? $etel['elsodatum'] : '-' ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center; white-space: nowrap;">
                        
                        <button onclick="editEtel(<?= $etel['id'] ?>, '<?= addslashes($etel['nev']) ?>', <?= $etel['kategoriaid'] ?>, '<?= $etel['felirdatum'] ?>', '<?= $etel['elsodatum'] ?>')" style="padding: 5px 10px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">Szerkesztés</button>
                        
                        <form action="crud" method="post" style="display:inline;" onsubmit="return confirm('Biztosan törölni szeretné ezt az ételt?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $etel['id'] ?>">
                            <input type="submit" value="Törlés" style="padding: 5px 10px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;">
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editEtel(id, nev, kategoriaid, felirdatum, elsodatum) {
    document.getElementById('formCim').innerText = 'Étel módosítása';
    document.getElementById('action').value = 'update';
    document.getElementById('etel_id').value = id;
    document.getElementById('nev').value = nev;
    document.getElementById('kategoriaid').value = kategoriaid;
    document.getElementById('felirdatum').value = felirdatum;
    document.getElementById('elsodatum').value = elsodatum;
    document.getElementById('submitBtn').value = 'Módosítás mentése';
    document.getElementById('submitBtn').style.background = '#007bff';
    window.scrollTo({ top: 0, behavior: 'smooth' }); // Felgörget az űrlaphoz
}

function resetForm() {
    document.getElementById('formCim').innerText = 'Új étel hozzáadása';
    document.getElementById('action').value = 'create';
    document.getElementById('etel_id').value = '';
    document.getElementById('crudForm').reset();
    document.getElementById('submitBtn').value = 'Hozzáadás';
    document.getElementById('submitBtn').style.background = '#28a745';
}
</script>