<?php 
// markAsGemaakt.php

declare(strict_types=1);
require_once 'BestellingLijst.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bestelID = (int)$_POST['bestelID'];
    $bestellingLijst = new BestellingLijst();
    $bestellingLijst->markeerAlsGemaakt($bestelID);
    header("Location: besteloverzicht.php");
    exit();
}

?>