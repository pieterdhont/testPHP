<?php
// order.php

declare(strict_types=1);
require_once 'BroodjeLijst.php';

// Start the session
session_start();

$broodje_id = $_POST['broodje_id'] ?? null;

if ($broodje_id) {
  $broodje = (new BroodjeLijst())->getBroodjeById((int) $broodje_id);
}

// Form submission handling
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'bestel') {
    $voornaam = $_POST['voornaam'] ?? null;
    $achternaam = $_POST['achternaam'] ?? null;
    $email = $_POST['email'] ?? null;

    if (!$voornaam || strlen($voornaam) > 50) {
        $error = "Ongeldige voornaam. Probeer het opnieuw.";
    } elseif (!$achternaam || strlen($achternaam) > 50) {
        $error = "Ongeldige achternaam. Probeer het opnieuw.";
    } elseif (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Ongeldig e-mailadres. Probeer het opnieuw.";
    } else {
        // Store form data in the session
        $_SESSION['order_data'] = [
            'broodje_id' => $broodje_id,
            'voornaam' => $voornaam,
            'achternaam' => $achternaam,
            'email' => $email,
            'pickup_time' => $_POST['pickup_time']
        ];
        // No validation errors, redirect to confirm_order.php
        header("Location: confirm_order.php");
        exit;
    }
}
?>

<html>

<head>
  <title>Bestel een Broodje</title>
</head>

<body>
  <?php if (isset($broodje)): ?>
    <h1>Bestel Broodje: <?= $broodje->getNaam() ?></h1>

    <?php if (isset($error)): ?>
      <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="order.php" method="post">
      <input type="hidden" name="broodje_id" value="<?= $broodje_id ?>">
      <label>Voornaam: <input type="text" name="voornaam" required></label>
      <label>Achternaam: <input type="text" name="achternaam" required></label>
      <label>Email: <input type="email" name="email" required></label>
      <label>Afhalingsmoment: <input type="datetime-local" name="pickup_time" required></label>
      <input type="hidden" name="action" value="bestel">
      <input type="submit" value="Plaats Bestelling">
    </form>
  <?php else: ?>
    <p>Broodje niet geselecteerd of gevonden.</p>
  <?php endif; ?>
</body>

</html>
