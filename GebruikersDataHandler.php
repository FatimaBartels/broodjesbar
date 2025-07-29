<?php
declare(strict_types = 1);

require_once "Gebruiker.php";

class GebruikersDataHandler
{
    private ?PDO $dbh = null;

    public function getGebruikersList(): array
    {

        $this->connect();

        $stmt = $this->dbh->prepare(
            "select id, naam, email, paswoord from gebruikers;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultGebruiker = [];

        foreach ($data as $row) {
            $resultGebruiker[] = Gebruiker::create(
                $row['naam'],
                $row['email'],
                $row['paswoord'],
                (int)$row['id']
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