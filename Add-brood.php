<?php

declare(strict_types = 1);

require_once 'Broodje.php';
require_once 'BroodjesDataHandler.php';

if (isset($_POST['Naam'], $_POST['Omschrijving'], $_POST['Prijs'])) {
    $Naam = trim($_POST['Naam']);
    $Omschrijving = $_POST['Omschrijving'];
    $Prijs = $_POST['Prijs'];

    if (!empty($Naam) && !empty($Omschrijving) && !empty($Prijs)) {

        $broodjeLijst = new BroodjesDataHandler();
        $brood = Broodje::create(
            $_POST['Naam'],
            $_POST['Omschrijving'],
            (float)$_POST['Prijs'] 
    );


        $broodjeLijst->addBrood($brood);

      
        
    }

    
}

header('location: BroodjesOverzicht.php');