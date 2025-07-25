<?php

// Class Gebruiker.php

class Gebruiker
{
    private ?int $id;
    private string $naam;
   
  

    public function __construct(?int $id, string $naam)
    {
        $this->id    = $id;
        $this->naam  = $naam;
      
       
    }

    public static function create(
        ?int $id=null, string $naam
        ): Gebruiker

    {
        return new Gebruiker($id, $naam );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

}
