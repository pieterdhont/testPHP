<?php
// KlantLijst.php

declare(strict_types=1);

require_once 'DatabaseConnected.php';
require_once 'Klant.php';

class KlantLijst extends DatabaseConnected 
{
  

  public function voegKlantToe(string $voornaam, string $achternaam, string $email): int
  {
    $sql = "INSERT INTO klanten (voornaam, achternaam, email) VALUES (:voornaam, :achternaam, :email)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
    $stmt->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return (int) $this->db->lastInsertId();
  }

  public function getKlantById(int $id): Klant
  {
    $sql = "SELECT * FROM klanten WHERE klantID = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      throw new Exception("Klant with ID $id not found.");
    }

    return new Klant(
      (int) $row['klantID'],
      $row['voornaam'],
      $row['achternaam'],
      $row['email']
    );
  }
}