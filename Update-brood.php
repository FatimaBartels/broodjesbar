<?php

declare(strict_types = 1);

require_once 'Broodje.php';
require_once 'BroodjesDataHandler.php';

if (
    isset($_POST, $_POST['Naam'], $_POST['Omschrijving'], $_POST['Prijs'], $_POST['ID']) &&
    !empty($_POST['Naam']) &&
    !empty($_POST['Omschrijving']) &&
    !empty((float)$_POST['Prijs']) &&
    !empty((int)$_POST['ID'])
) {
    $broodlijst = new BroodjesDataHandler();
    $brood = Broodje::create(
        $_POST['Naam'],
        $_POST['Omschrijving'],
        (float)$_POST['Prijs'],
        (int)$_POST['ID']
    );

    $broodlijst->updateBrood($brood);
}

header('location: BroodjesOverzicht.php');