<h2>Beérkezett üzenetek</h2>

<?php if (!empty($lekkerdezes_hiba)): ?>
    <div style="background: #ffc; padding: 10px; border-left: 5px solid #f00;">
        <strong><?= $lekkerdezes_hiba ?></strong>
    </div>
<?php elseif (empty($uzenetek_lista)): ?>
    <div style="background: #f4f4f4; padding: 15px; border-radius: 8px; color: #666;">
        <p>Jelenleg nincsenek beérkezett üzenetek.</p>
    </div>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <thead style="background: #333; color: #fff;">
            <tr>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Név</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Üzenet</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Dátum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uzenetek_lista as $uzenet): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; width: 20%;">
                        <?= htmlspecialchars($uzenet['nev']) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; width: 60%;">
                        <?= nl2br(htmlspecialchars($uzenet['szoveg'])) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center; width: 20%;">
                        <?= $uzenet['datum'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>