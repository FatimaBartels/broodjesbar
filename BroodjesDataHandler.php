<?php
declare(strict_types = 1);

require_once "Broodje.php";

class BroodjesDataHandler
{
    private ?PDO $dbh = null;

    public function getBroodjesList(): array
    {

        $this->connect();

        $stmt = $this->dbh->prepare(
            "select ID, Naam, Omschrijving, Prijs from broodjes;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultBroodje = [];

        foreach ($data as $row) {
            $resultBroodje[] = Broodje::create(   
                $row['Naam'],
                $row['Omschrijving'], 
                (float)$row['Prijs'],
                (int)$row['ID']
            );



        }

        return $resultBroodje;
    }

    public function addBrood(Broodje $brood)
    {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "INSERT INTO broodjes (Naam, Omschrijving, Prijs)
                    VALUES (:Naam, :Omschrijving, :Prijs);"
        );
    
    
        $stmt->execute(
            [
                ':Naam'  => $brood->getBroodNaam(),
                ':Omschrijving' => $brood->getOmschrijving(),
                ':Prijs' => $brood->getPrijs(),

            ]
            );
           
            $this->disconnect();
    
        

    }     
    

    public function removeBroodById(int $ID)
        {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "DELETE FROM broodjes where ID = :ID;"
        );

        $stmt->execute([':ID' => $ID]);
        $this->disconnect();
    }


    public function getBroodById(int $ID): ?Broodje
    {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "select ID, Naam, Omschrijving, Prijs from broodjes where ID = :ID"
        );
        $stmt->execute([':ID' => $ID]);

        $broodRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->disconnect();

        if (empty($broodRecord)) return null;

        return Broodje::create(
            $broodRecord['Naam'],
            $broodRecord['Omschrijving'],
            (float)$broodRecord['Prijs'],
            (int)$broodRecord['ID']
        );
    }

    public function updateBrood(Broodje $brood) 
        {
        $this->connect();
        $stmt = $this->dbh->prepare(
            "update broodjes 
                    set Naam = :Naam,
                        Omschrijving = :Omschrijving,
                        Prijs = :Prijs
                    where ID = :ID; "
        );


        $stmt->execute(
            [
                ':Naam'    => $brood->getBroodNaam(),
                ':Omschrijving' => $brood->getOmschrijving(),
                ':Prijs' => $brood->getPrijs(),
                ':ID'       => $brood->getBroodId(),

            ]
        );
       
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