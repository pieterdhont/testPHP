<?php 
// DatabaseConnected.php

declare(strict_types=1);
require_once 'Database.php';

class DatabaseConnected {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
}
?>