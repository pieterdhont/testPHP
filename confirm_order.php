<?php 
//confirm_order.php

declare(strict_types=1);

require_once 'BestellingLijst.php';
require_once 'KlantLijst.php'; 

// Start the session
session_start();

// Check if session data is set
if (!isset($_SESSION['order_data'])) {
    die("Invalid request.");
}

$broodje_id = (int)$_SESSION['order_data']['broodje_id'];
$voornaam = $_SESSION['order_data']['voornaam'];
$achternaam = $_SESSION['order_data']['achternaam'];
$email = $_SESSION['order_data']['email'];
$pickupTime = $_SESSION['order_data']['pickup_time'];

// Unset the session data now that we've retrieved it
unset($_SESSION['order_data']);

$currentTime = date('Y-m-d H:i:s');
$baseurl = 'broodje_bestellen.php';

if (strtotime($pickupTime) - strtotime($currentTime) < 1800) {
    echo "Afhalingsmoment moet minstens 30 minuten in de toekomst liggen. U wordt terug gestuurd naar de homepagina.";
    header("refresh:3;url=$baseurl");
    exit; 
}

$klantLijst = new KlantLijst();
$existingKlant = $klantLijst->getKlantByEmail($email);
if ($existingKlant === null) {
    $klantID = $klantLijst->voegKlantToe($voornaam, $achternaam, $email);
} else {
    $klantID = $existingKlant->getKlantId();
}

$bestellingLijst = new BestellingLijst();
if ($bestellingLijst->plaatsBestelling($broodje_id, $klantID, $pickupTime)) {
    echo "Uw bestelling is geplaatst. U wordt terug gestuurd naar de homepagina.";
    header("refresh:3;$baseurl");
    exit; 
} else {
    echo "Uw bestelling is niet geplaatst. U wordt terug gestuurd naar de homepagina.";
    header("refresh:3;$baseurl");
    exit; 
}

?>
