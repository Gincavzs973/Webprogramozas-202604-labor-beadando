<h2>Képgaléria</h2>

<?php if (!empty($uzenet)): ?>
    <div style="background: #ffc; padding: 10px; margin-bottom: 15px; border-left: 5px solid #ff9900;">
        <ul style="margin: 0; padding-left: 20px;">
            <?php foreach ($uzenet as $u): ?>
                <li><strong><?= $u ?></strong></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['login'])): ?>
    <div style="background: #e6f7ff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <h3>Új kép feltöltése</h3>
        <form action="kepek" method="post" enctype="multipart/form-data">
            <input type="file" name="fajl" required accept="image/jpeg, image/png">
            <input type="submit" name="kuld" value="Feltöltés">
        </form>
    </div>
<?php else: ?>
    <div style="background: #f4f4f4; padding: 15px; border-radius: 8px; margin-bottom: 20px; color: #666;">
        <em>Kép feltöltéséhez kérjük, <a href="belepes">jelentkezz be</a>!</em>
    </div>
<?php endif; ?>

<div style="display: flex; flex-wrap: wrap; gap: 15px;">
    <?php foreach ($kepek as $kep): ?>
        <div style="border: 1px solid #ccc; padding: 5px; background: #fff; border-radius: 5px;">
            <img src="<?= $MAPPA . $kep ?>" alt="Galéria kép" style="max-width: 250px; height: auto; display: block;">
        </div>
    <?php endforeach; ?>
</div>