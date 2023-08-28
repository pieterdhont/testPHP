<?php
//broodjes_bestellen.php

declare(strict_types=1);

require_once 'BroodjeLijst.php';

$broodjeLijst = new BroodjeLijst();
$broodjes = $broodjeLijst->getBroodjes();
?>

<html>

<head>
    <title>Broodjes</title>
</head>

<body>
    <h1>Selecteer een Broodje</h1>
    <form action="order.php" method="post">
        <select name="broodje_id">
            <?php
            foreach ($broodjes as $broodje) {
                echo "<option value='{$broodje->getID()}'>{$broodje->getNaam()} - {$broodje->getOmschrijving()} - €{$broodje->getPrijs()}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Select Broodje">
    </form>
    <p><a href="index.html">Terug naar de Hoofdpagina</a></p>
</body>

</html>