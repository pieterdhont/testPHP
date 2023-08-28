<?php
// besteloverzicht.php

declare(strict_types=1);
require_once 'BestellingLijst.php';

$bestellingLijst = new BestellingLijst();
$bestellingen = $bestellingLijst->getBestellingen();

?>

<html>

<head>
  <title>Besteloverzicht</title>
  <style>
    .gemaakt {
      background-color: #ddd;
    }
  </style>
</head>

<body>
  <h1>Besteloverzicht</h1>
  <table>
    <thead>
      <tr>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Broodje</th>
        <th>Afhalingsmoment</th>
        <th>Status</th>
        <th>Acties</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bestellingen as $bestelling): ?>
        <tr class="<?= $bestelling->getStatus()->getStatus() === "Gemaakt" ? "gemaakt" : "" ?>">
          <td>
            <?= $bestelling->getKlant()->getVoornaam() ?>
          </td>
          <td>
            <?= $bestelling->getKlant()->getAchternaam() ?>
          </td>
          <td>
            <?= $bestelling->getBroodje()->getNaam() ?>
          </td>
          <td>
            <?= $bestelling->getAfhalingsmoment() ?>
          </td>
          <td>
            <?= $bestelling->getStatus()->getStatus() ?>
          </td> <!-- Corrected line here -->
          <td>
            <?php if ($bestelling->getStatus()->getStatus() !== "Gemaakt"): ?> 
              <form action="markAsGemaakt.php" method="post">
                <input type="hidden" name="bestelID" value="<?= $bestelling->getBestelID() ?>">
                
                <input type="submit" value="Mark as Gemaakt">
              </form>
            <?php else: ?>
              <form action="markAsAfgehaald.php" method="post">
                <input type="hidden" name="bestelID" value="<?= $bestelling->getBestelID() ?>">
                
                <input type="submit" value="Mark as Afgehaald">
              </form>
            <?php endif; ?>
          </td>
        </tr>

      <?php endforeach; ?>
    </tbody>
  </table>

    <p><a href="index.html">Terug naar de Hoofdpagina</a></p>
</body>

</html>

