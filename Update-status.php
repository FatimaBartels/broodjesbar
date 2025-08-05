<?php
declare(strict_types=1);

require_once 'BestellingsDataHandler.php';
require_once 'StatussenDataHandler.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: BestellingenOverzicht.php');
    exit;
}

$bestellingId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$statusNaam  = filter_input(INPUT_POST, 'status');

if (!$bestellingId || !$statusNaam) {
    die("Ongeldige aanvraag.");
}

$statusHandler = new StatussenDataHandler();
$status = $statusHandler->getStatusByName($statusNaam);
if (!$status) {
    die("Status bestaat niet.");
}

$bestellingHandler = new BestellingsDataHandler();
$bestellingHandler->updateStatus($bestellingId, (int)$status->getStatusId());

header("Location: BestellingenOverzicht.php");
exit;

