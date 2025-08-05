<?php
// updateBroodForm.php

declare(strict_types = 1);

require_once 'BroodjesDataHandler.php';

$film = null;

if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $broodlijst    = new BroodjesDataHandler();
    $brood = $broodlijst->getBroodById((int)$_GET['id']);
}

if (null === $brood) {
    header('location: BroodjesOverzicht.php');
    die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css"> 
    <title>Update Brood</title>
</head>
<body>

<div class="container">
    <h2>Pas brood aan</h2>
    <form action="Update-brood.php" method="post">
        <input type="text"
            name="ID"
            value="<?= $brood->getBroodId(); ?>"
            hidden="hidden"
        />
    <br/>
        <label>Naam: </label>
        <input type="text"
            name="Naam"
            value="<?= $brood->getBroodNaam(); ?>"
        />
        <br/>
        <label>Omschrijving: </label>
        <input type="text"
            name="Omschrijving"
            value="<?= $brood->getOmschrijving(); ?>"
        />
        <br/>
        <label>Prijs: € </label>
        <input type="text"
            name="Prijs"
            value="<?= $brood->getPrijs(); ?>"
        />
        <br/>
        <button type="submit" class="btn">Bewaren</button>
    </form>
</div>
</body>
</html>
