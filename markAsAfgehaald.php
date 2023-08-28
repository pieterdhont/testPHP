<?php 
// markAsAfgehaald.php

declare(strict_types=1);
require_once 'BestellingLijst.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bestelID = (int)$_POST['bestelID'];
    $bestellingLijst = new BestellingLijst();
    $bestellingLijst->markeerAlsAfgehaald($bestelID);
    header("Location: besteloverzicht.php");
    exit();
}

?>