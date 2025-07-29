<?php

declare(strict_types = 1);



require_once 'BroodjesDataHandler.php';


if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $broodLijst  = new BroodjesDataHandler();
    $broodLijst ->removeBroodById((int)$_GET['id']);
}


header('location: BroodjesOverzicht.php');