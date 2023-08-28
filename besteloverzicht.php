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
            <?php foreach ($bestellingen as $bestelling): 
                
                // Preprocess data
                $isGemaakt = $bestelling->getStatus()->getStatus() === "Gemaakt";
                $action = $isGemaakt ? "markAsAfgehaald.php" : "markAsGemaakt.php";
                $buttonLabel = $isGemaakt ? "Mark as Afgehaald" : "Mark as Gemaakt";
            ?>
            <tr class="<?= $isGemaakt ? "gemaakt" : "" ?>">
                <td><?= $bestelling->getKlant()->getVoornaam() ?></td>
                <td><?= $bestelling->getKlant()->getAchternaam() ?></td>
                <td><?= $bestelling->getBroodje()->getNaam() ?></td>
                <td><?= $bestelling->getAfhalingsmoment() ?></td>
                <td><?= $bestelling->getStatus()->getStatus() ?></td>
                <td>
                    <form action="<?= $action ?>" method="post">
                        <input type="hidden" name="bestelID" value="<?= $bestelling->getBestelID() ?>">
                        <input type="submit" value="<?= $buttonLabel ?>">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="index.html">Terug naar de Hoofdpagina</a></p>
</body>

</html>


