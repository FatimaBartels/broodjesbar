<?php

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
                (int)$row['ID'], 
                $row['Naam'],
                $row['Omschrijving'], 
                $row['Prijs']
            );



        }

        return $resultBroodje;
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