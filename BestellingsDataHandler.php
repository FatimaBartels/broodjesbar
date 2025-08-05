<?php
declare(strict_types=1);

require_once "Bestelling.php";
require_once "StatussenDataHandler.php";

class BestellingsDataHandler
{
    private ?PDO $dbh = null;
    private StatussenDataHandler $statusHandler;

      public function __construct()
    {
        $this->statusHandler = new StatussenDataHandler();
    }


    public function getBestellingsList(): array
    {
         $afgehaaldeStatus = $this->statusHandler->getStatusByName('afgehaald');
        $afgehaaldId = $afgehaaldeStatus ? $afgehaaldeStatus->getStatusId() : -1;
        
        $this->connect();

        $stmt = $this->dbh->prepare(
            "SELECT id, broodjeId, gebruikerId, datum, statusId FROM bestellingen WHERE statusId != :afgehaald ORDER BY datum ASC;"
        );

       
        $stmt->execute([':afgehaald' => $afgehaaldId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultBestelling = [];
        foreach ($data as $bestelling) {
            $datum = DateTime::createFromFormat('Y-m-d H:i:s', $bestelling['datum']);
            $resultBestelling[] = Bestelling::create(
                (int)$bestelling['id'],
                (int)$bestelling['broodjeId'],
                (int)$bestelling['gebruikerId'],
                $datum,
                (int)$bestelling['statusId']
            );
        }

        return $resultBestelling;
    }

    public function bestellingToegevoegd(int $broodjeId, int $gebruikerId): bool
    {
        $this->connect();

        $stmt = $this->dbh->prepare(
            "SELECT COUNT(*) FROM bestellingen 
        WHERE broodjeId = :broodjeId AND gebruikerId = :gebruikerId"
        );

        $stmt->execute([
        ':broodjeId' => $broodjeId,
        ':gebruikerId' => $gebruikerId
    ]);
        $count = (int)$stmt->fetchColumn();

        $this->disconnect();

        return $count > 0;
    }


    public function addBestelling(Bestelling $bestelling): void
    {
        $this->connect();

        $stmt = $this->dbh->prepare(
            "INSERT INTO bestellingen (broodjeId, gebruikerId, datum, statusId)
             VALUES (:broodjeId, :gebruikerId, :datum, :statusId)"
        );

        $stmt->execute([
            ':broodjeId' => $bestelling->getBroodjeId(),
            ':gebruikerId' => $bestelling->getGebruikerId(),
            ':datum' => $bestelling->getDatum()->format('Y-m-d H:i:s'),
            ':statusId' => $bestelling->getStatusId()
        ]);

        $this->disconnect();
    }

    public function updateStatus(int $bestelID, int $statusID): void    
    {
        $this->connect();

        $stmt = $this->dbh->prepare("UPDATE bestellingen SET statusID = :statusID WHERE id = :id");

        $stmt->bindValue(':statusID', $statusID, PDO::PARAM_INT);
        $stmt->bindValue(':id', $bestelID, PDO::PARAM_INT);

        $stmt->execute();

        $this->disconnect();
    }


    public function removeBestellingById(int $id): void
    {
        $this->connect();

        $stmt = $this->dbh->prepare("DELETE FROM bestellingen WHERE id = :id;");
        $stmt->execute([':id' => $id]);
        
        $this->disconnect();
    }


    private function connect(): void
    {
        $this->dbh = new PDO(
            "mysql:host=localhost;port=3307;dbname=broodjesbar;charset=utf8",
            "root",
            ''
        );
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function disconnect(): void
    {
        $this->dbh = null;
    }

}
