<?php
// BroodjeLijst.php

declare(strict_types=1);

require_once 'Database.php';
require_once 'Broodje.php';

class BroodjeLijst
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function getBroodjes(): array
  {
    $sql = "SELECT * FROM broodjes";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $broodjes = [];
    foreach ($result as $row) {
      $broodjes[] = new Broodje((int) $row['ID'], $row['Naam'], $row['Omschrijving'], (float) $row['Prijs']);
    }
    return $broodjes;
  }

  public function getBroodjeById(int $id): Broodje
  {
    $sql = "SELECT * FROM broodjes WHERE ID = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      throw new Exception("Broodje with ID $id not found.");
    }

    return new Broodje(
      (int) $row['ID'],
      $row['Naam'],
      $row['Omschrijving'],
      (float) $row['Prijs']
    );
  }
}