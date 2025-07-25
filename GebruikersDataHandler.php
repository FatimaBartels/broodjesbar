<?php

require_once "Gebruiker.php";

class GebruikersDataHandler
{
    private ?PDO $dbh = null;

    public function getGebruikersList(): array
    {

        $this->connect();

        $stmt = $this->dbh->prepare(
            "select id, naam from gebruikers;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultGebruiker = [];

        foreach ($data as $row) {
            $resultGebruiker[] = Gebruiker::create(
                (int)$row['id'], 
                $row['naam']
            );



        }

        return $resultGebruiker;
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