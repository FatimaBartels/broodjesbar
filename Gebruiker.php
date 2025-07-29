<?php

declare(strict_types=1);

// Class Gebruiker.php

class Gebruiker
{
    private ?int $id;
    private string $naam;
    private string $email;
    private string $paswoord;
   
  

    public function __construct(?int $id, string $naam, string $email, string $paswoord)
    {
        $this->id    = $id;
        $this->naam  = $naam;
        $this->email = $email;
        $this->paswoord = $paswoord;
      
       
    }

    public static function create(
         string $naam, string $email, string $paswoord, ?int $id=null,
        ): Gebruiker

    {
        return new Gebruiker($id, $naam, $email, $paswoord );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPaswoord(): string
    {
        return $this->paswoord;
    }

}
