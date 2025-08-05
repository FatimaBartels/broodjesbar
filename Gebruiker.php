<?php

declare(strict_types=1);

// Class Gebruiker.php

class Gebruiker
{
    private ?int $id;
    private string $voornaam;
    private string $naam;
    private string $email;
  
   
  

    public function __construct(?int $id, string $voornaam, string $naam, string $email)
    {
        $this->id    = $id;
        $this->voornaam  = $voornaam;
        $this->naam  = $naam;
        $this->email = $email;
      
      
       
    }

    public static function create(
         string $voornaam, string $naam, string $email, ?int $id=null,
        ): Gebruiker

    {
        return new Gebruiker($id, $voornaam, $naam, $email);
    }

    public function getGebruikersId(): ?int
    {
        return $this->id;
    }

     public function getGebruikerVoorNaam(): string
    {
        return $this->voornaam;
    }

    public function getGebruikerNaam(): string
    {
        return $this->naam;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}
