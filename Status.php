<?php

declare(strict_types=1);

// Class Status.php

class Status
{
    private ?int $statusId;
    private string $Status;
   
   
  

    public function __construct(?int $statusId, string $Status)
    {
        $this->statusId    = $statusId;
        $this->Status  = $Status;
   
      
       
    }

    public static function create(
         string $Status, ?int $statusId=null,
        ): Status

    {
        return new Status($statusId, $Status);
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function getStatus(): string
    {
        return $this->Status;
    }

    

}
