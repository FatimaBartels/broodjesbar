<?php
declare(strict_types = 1);

require_once "Status.php";

class StatussenDataHandler
{
    private ?PDO $dbh = null;

    public function getStatussenList(): array
    {

        $this->connect();

        $stmt = $this->dbh->prepare(
            "SELECT statusId, Status FROM Statussen;"
        );

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->disconnect();

        $resultStatus = [];

        foreach ($data as $row) {
            $resultStatus[] = Status::create(
                $row['Status'],
               
                (int)$row['statusId']
            );



        }

        return $resultStatus;
    }

   
   public function getStatusByName(string $naam): ?Status
    {
        $this->connect();

        $stmt = $this->dbh->prepare("SELECT statusId, Status FROM Statussen WHERE Status = :naam LIMIT 1");

        $stmt->execute([':naam' => $naam]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->disconnect();

        if ($row) {
            return Status::create($row['Status'], (int)$row['statusId']);
        }
        return null;
    }

    public function getStatusById(int $id): ?Status
    {
        $this->connect();

        $stmt = $this->dbh->prepare("SELECT statusId, Status FROM Statussen WHERE statusId = :id LIMIT 1");

        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->disconnect();

        if ($row) {
            return Status::create($row['Status'], (int)$row['statusId']);
        }
        return null;
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