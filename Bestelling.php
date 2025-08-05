<?php

declare(strict_types=1);

require_once "Gebruiker.php";
require_once "Broodje.php";


class Bestelling
{
    private ?int $id;
    private int $broodjeId;
    private int $gebruikerId;
    private DateTime $datum;
    private int $statusId;

     private ?PDO $dbh = null;

    private function __construct(?int $id, int $broodjeId, int $gebruikerId, DateTime $datum, int $statusId)
    {
        $this->id = $id;
        $this->broodjeId = $broodjeId;
        $this->gebruikerId = $gebruikerId;
        $this->datum = $datum;
        $this->statusId = $statusId;
    }

    public static function create(?int $id, int $broodjeId, int $gebruikerId, DateTime $datum, int $statusId): Bestelling
    {
        return new Bestelling($id, $broodjeId, $gebruikerId, $datum, $statusId);
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBroodjeId(): int
    {
        return $this->broodjeId;
    }

    public function getGebruikerId(): int
    {
        return $this->gebruikerId;
    }

    public function getDatum(): DateTime
    {
        return $this->datum;
    }

     public function getStatusId(): int
    {
    return $this->statusId;
    }



    public function getGebruiker() {
    
    $this->connect();

  
    $stmt = $this->dbh->prepare("SELECT * FROM gebruikers WHERE id = :id");

    $stmt->execute([':id' => $this->gebruikerId]);

    $gebruikerResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gebruikerResult) {
        $this->disconnect();
        return new Gebruiker(0, "Onbekend", "Onbekend", "Onbekend");
    }

        $gebruiker = new Gebruiker(
        (int)$gebruikerResult["id"],
        $gebruikerResult["voornaam"],
        $gebruikerResult["naam"], 
        $gebruikerResult["email"]
        
    
    );

    $this->disconnect();

    return $gebruiker;
    }
     
    
    public function getBroodje() {

        $this->connect();

        $stmt = $this->dbh->prepare("SELECT * FROM broodjes WHERE ID = :ID");
    
        $stmt->execute([':ID' => $this->broodjeId]);

        $broodjeResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$broodjeResult) {

        $this->disconnect();
        return new Broodje(0, "Onbekend", "Onbekend", 0.0);
    }

      
        $broodje = new Broodje(
        (int)$broodjeResult["ID"],
        $broodjeResult["Naam"],
        $broodjeResult["Omschrijving"],
        (float)$broodjeResult["Prijs"]
        
        );

        $this->disconnect();

        return $broodje;
    }

    private function connect()
    {
        $this->dbh = new PDO(
            "mysql:host=localhost;port=3307;dbname=broodjesbar;charset=utf8",
            "root",
            ''
        );

        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    private function disconnect()
    {
        $this->dbh = null;
    }


}
