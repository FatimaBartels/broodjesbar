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
            "select id, voornaam, naam, email from gebruikers;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultGebruiker = [];

        foreach ($data as $row) {
            $resultGebruiker[] = Gebruiker::create(
                $row['voornaam'],
                $row['naam'],
                $row['email'],
                (int)$row['id']
            );



        }

        return $resultGebruiker;
    }

     public function addGebruiker(Gebruiker $gebruiker): int
    {
        $this->connect();   
        
        $existing = $this->getGebruikerByEmail($gebruiker->getEmail());
        if ($existing !== null) {
            return $existing->getGebruikersId();
        }


            $stmt = $this->dbh->prepare(
            "INSERT INTO gebruikers (voornaam, naam, email) VALUES (:voornaam, :naam, :email)"
        );
        $stmt->execute([
            ':voornaam' => $gebruiker->getGebruikerVoornaam(),
            ':naam' => $gebruiker->getGebruikerNaam(),
            ':email' => $gebruiker->getEmail(),
        ]);

        return (int)$this->dbh->lastInsertId();
       
           
            $this->disconnect();    

    }   
   

    public function getGebruikerByEmail(string $email): ?Gebruiker
    {
        $stmt = $this->dbh->prepare("SELECT * FROM gebruikers WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return Gebruiker::create($row['voornaam'], $row['naam'], $row['email'], (int)$row['id']);
    }

    
    public function getGebruikerById(int $id): ?Gebruiker
    {
        $stmt = $this->dbh->prepare("SELECT * FROM gebruikers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return Gebruiker::create($row['voornaam'], $row['naam'], $row['email'], (int)$row['id']);
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

