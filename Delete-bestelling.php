<?php

declare(strict_types = 1);



require_once 'BestellingsDataHandler.php';


if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $bestellingsLijst  = new BestellingsDataHandler();
    $bestellingsLijst ->removeBestellingById((int)$_GET['id']);
}


header('location: BestellingenOverzicht.php');