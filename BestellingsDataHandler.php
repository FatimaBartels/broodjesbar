<?php
declare(strict_types = 1);

require_once "Bestelling.php";

//BestellingsDataHandler.php

class BestellingsDataHandler
{
    private ?PDO $dbh = null;

    public function getBestellingsList(): array
    {
        $this->connect();

        $stmt = $this->dbh->prepare(
            "SELECT id, broodjeId, gebruikerId, datum FROM bestellingen;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultBestelling = [];
        foreach ($data as $bestelling) {
            $datum = DateTime::createFromFormat('Y-m-d H:i:s', $bestelling['datum']);
                $resultBestelling[] = Bestelling::create(
                (int)$bestelling['id'],
                (int)$bestelling['broodjeId'],
                (int)$bestelling['gebruikerId'],
                $datum
                
            );
        }

        return $resultBestelling;
    }
   
    public function bestellingToegevoegd(int $broodjeId, int $gebruikerId): bool {
        
        $this->connect();

        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM bestellingen WHERE broodjeId = :broodjeId AND gebruikerId = :gebruikerId");

        $stmt->execute([':broodjeId' => $broodjeId, ':gebruikerId' => $gebruikerId]);

        $count = $stmt->fetchColumn();

        $this->disconnect();

        return $count > 0;
    }
    


    public function addBestelling(Bestelling $bestelling)
    {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "INSERT INTO bestellingen (broodjeId, gebruikerId, datum )
                    VALUES (:broodjeId, :gebruikerId, :datum );"
        );
    
    
        $stmt->execute(
            [
                
                ':broodjeId'  => $bestelling->getBroodjeId(),
                ':gebruikerId' => $bestelling->getGebruikerId(),
                ':datum' => $bestelling->getDatum()->format('Y-m-d H:i:s'),
    

            ]
            );
           
            $this->disconnect();    

    }   
    

    public function getBestellingsVoorBroodje(int $broodjeId): array {

        $this->connect();

        $stmt = $this->dbh->prepare("SELECT id, broodjeId, gebruikerId, datum FROM bestellingen WHERE broodjeId = :broodjeId");
        $stmt->execute([':broodjeId' => $broodjeId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $bestellingsResult = [];

        foreach ($result as $row) {
            $datum = DateTime::createFromFormat('Y-m-d H:i:s', $row['datum']);
            $bestellingsResult[] = new Bestelling(
            (int)$row['id'],
            (int)$row['broodjeId'],
            (int)$row['gebruikerId'],
            $datum
    );
}


        return $bestellingsResult;
}


    public function getBestellingsByGebruikerId(int $gebruikerId): array {
        $this->connect();
    
        $stmt = $this->dbh->prepare(
            "SELECT * FROM bestellingen WHERE gebruikerId = :gebruikerId"
        );
    
        
        $stmt->execute([':gebruikerId' => $gebruikerId]);
    
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $this->disconnect();
    
        $result = [];

        foreach ($data as $bestel) {
            $datum = DateTime::createFromFormat('Y-m-d H:i:s', $bestel['datum']);
            $result[] = Bestelling::create(
            (int)$bestel['id'],
            (int)$bestel['broodjeId'],
            (int)$bestel['gebruikerId'],
            $datum
    );
    }


        return $result;
    }
    
    public function removeBestellingById(int $id)
        {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "DELETE FROM bestellingen where id = :id;"
        );

        $stmt->execute([':id' => $id]);
        $this->disconnect();
    }



    private function connect()
    {
        $this->dbh = new PDO(
            "mysql:host=localhost;port=3307;dbname=broodjesbar;charset=utf8",
            "root",
            ''
        );
    }

    private function disconnect()
    {
        $this->dbh = null;
    }


}