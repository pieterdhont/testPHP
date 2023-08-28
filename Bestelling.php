<?php
//Bestelling.php

declare(strict_types=1);

class Bestelling
{
  private int $bestelID;
  private Broodje $broodje;
  private Klant $klant;
  private $afhalingsmoment;
  private Status $status;

  public function __construct(int $bestelID, Broodje $broodje, Klant $klant, $afhalingsmoment, Status $status)
  {
    $this->bestelID = $bestelID;
    $this->broodje = $broodje;
    $this->klant = $klant;
    $this->afhalingsmoment = $afhalingsmoment;
    $this->status = $status;
  }

  public function getBestelID(): int
  {
    return $this->bestelID;
  }

  public function getBroodje(): Broodje
  {
    return $this->broodje;
  }

  public function getKlant(): Klant
  {
    return $this->klant;
  }

  public function getAfhalingsmoment(): string
  {
    return $this->afhalingsmoment;
  }

  public function getStatus(): Status
  {
    return $this->status;
  }
}

?>