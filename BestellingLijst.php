<?php
//BestellingLijst.php

declare(strict_types=1);

require_once 'Database.php';
require_once 'BroodjeLijst.php';
require_once 'KlantLijst.php';
require_once 'StatusLijst.php';
require_once 'Bestelling.php';

class BestellingLijst
{
  private PDO $db;
  private BroodjeLijst $broodjeLijst;
  private KlantLijst $klantLijst;
  private StatusLijst $statusLijst;

  public function __construct()
  {
    $this->db = Database::getConnection();
    $this->broodjeLijst = new BroodjeLijst();
    $this->klantLijst = new KlantLijst();
    $this->statusLijst = new StatusLijst();
  }

  public function plaatsBestelling(int $broodjeID, int $klantID, string $afhalingsmoment): bool
  {
    $statusID = 1;
    $sql = "INSERT INTO bestellingen (broodjeID, klantID, afhalingsmoment, statusID) VALUES (:broodjeID, :klantID, :afhalingsmoment, :statusID)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':broodjeID', $broodjeID, PDO::PARAM_INT);
    $stmt->bindParam(':klantID', $klantID, PDO::PARAM_INT);
    $stmt->bindParam(':afhalingsmoment', $afhalingsmoment, PDO::PARAM_STR);
    $stmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function getBestellingen(): array
  {
    $sql = "SELECT * FROM bestellingen WHERE statusID <> 3 ORDER BY afhalingsmoment ASC";
    $stmt = $this->db->query($sql);
    $bestellingen = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $bestellingen[] = new Bestelling(
        (int) $row['bestelID'],
        $this->broodjeLijst->getBroodjeById((int) $row['broodjeID']),
        $this->klantLijst->getKlantById((int) $row['klantID']),
        $row['afhalingsmoment'],
        $this->statusLijst->getStatusById((int) $row['statusID'])
      );
    }

    return $bestellingen;
  }

  public function markeerAlsGemaakt(int $bestelID): bool
  {
    $statusID = 2;
    $sql = "UPDATE bestellingen SET statusID = :statusID WHERE bestelID = :bestelID";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
    $stmt->bindParam(':bestelID', $bestelID, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function markeerAlsAfgehaald(int $bestelID): bool
  {
    $statusID = 3;
    $sql = "UPDATE bestellingen SET statusID = :statusID WHERE bestelID = :bestelID";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':statusID', $statusID, PDO::PARAM_INT);
    $stmt->bindParam(':bestelID', $bestelID, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
?>