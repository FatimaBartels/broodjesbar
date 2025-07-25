<?php

// Class Broodje.php

class Broodje
{
    private ?int $ID;
    private string $Naam;
    private string $Omschrijving;
    private string $Prijs;
   
  

    public function __construct(?int $ID, string $Naam, string $Omschrijving, float $Prijs)
    {
        $this->ID    = $ID;
        $this->Naam  = $Naam;
        $this->Omschrijving  = $Omschrijving;
        $this->Prijs  = $Prijs;
      
       
    }

    public static function create(
         string $Naam, string $Omschrijving, float $Prijs, ?int $ID=null): Broodje


    {
        return new Broodje( $Naam, $Omschrijving, $Prijs, $ID);
    }


    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getNaam(): string
    {
        return $this->Naam;
    }

    public function getOmschrijving(): string
    {
        return $this->Omschrijving;
    }

    public function getPrijs(): float
    {
        return $this->Prijs;
    }

}
