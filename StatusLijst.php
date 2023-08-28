<?php
// StatusLijst.php

declare(strict_types=1);

require_once 'Database.php';
require_once 'Status.php';

class StatusLijst
{
  private PDO $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function getStatussen(): array
  {
    $sql = "SELECT * FROM statussen";
    $stmt = $this->db->query($sql);
    $statussen = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $statussen[] = new Status((int) $row['statusID'], $row['Status']);
    }
    return $statussen;
  }

  public function getStatusById(int $id): Status
  {
    $sql = "SELECT * FROM statussen WHERE statusID = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      throw new Exception("Status with ID $id not found.");
    }

    return new Status(
      (int) $row['statusID'],
      $row['Status']
    );
  }
}