<?php
declare(strict_types=1);

session_start();

require_once 'BestellingsDataHandler.php';
require_once 'StatussenDataHandler.php';
require_once 'Gebruiker.php'; 

// timezone
date_default_timezone_set('Europe/Brussels');

// sanitize/input
$voornaam   = trim($_POST['voornaam'] ?? '');
$achternaam = trim($_POST['achternaam'] ?? '');
$email      = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$broodjeId  = isset($_POST['broodjeId']) ? (int)$_POST['broodjeId'] : null;
$tijdstip   = $_POST['tijdstip'] ?? null;

if (!$voornaam || !$achternaam || !$email || !$broodjeId || !$tijdstip) {
    die("Alle velden moeten ingevuld zijn.");
}

// tijdstip validatie - minstens 30 minuten in de toekomst
try {
    $gekozen = new DateTime($tijdstip);
} catch (Exception $e) {
    die("Ongeldig datumformaat.");
}
$nu = new DateTime();
$minTijd = (clone $nu)->modify('+30 minutes');
if ($gekozen < $minTijd) {
     $_SESSION['error'] = "Het afhaalmoment moet minstens 30 minuten in de toekomst liggen.";
    header("Location: index.php");
    exit;
    //die("Het afhaalmoment moet minstens 30 minuten in de toekomst liggen.");
}

// maak verbinding naar de database
$dbh = new PDO("mysql:host=localhost;port=3307;dbname=broodjesbar;charset=utf8", "root", "");

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// haal of maak gebruiker op basis van e-mail
$stmt = $dbh->prepare("SELECT id, voornaam, naam, email FROM gebruikers WHERE email = :email LIMIT 1");

$stmt->execute([':email' => $email]);

$gebruikerRow = $stmt->fetch(PDO::FETCH_ASSOC);

if ($gebruikerRow) {
    $gebruikerId = (int)$gebruikerRow['id'];
} else {
    $insertUsr = $dbh->prepare("INSERT INTO gebruikers (voornaam, naam, email) VALUES (:voornaam, :achternaam, :email)");
    $insertUsr->execute([
        ':voornaam' => $voornaam,
        ':achternaam' => $achternaam,
        ':email' => $email
    ]);
    $gebruikerId = (int)$dbh->lastInsertId();
}

// haal statusID van "Besteld"
$statusHandler = new StatussenDataHandler();
$statusBesteld = $statusHandler->getStatusByName('Besteld');
if (!$statusBesteld) {
    $_SESSION['error'] = "Status 'Besteld' bestaat niet in de database.";
    header("Location: index.php");
    exit;
    //die("Status 'Besteld' bestaat niet in de database.");
}
$statusId = $statusBesteld->getStatusId();

// controleren of deze gebruiker dit broodje al besteld heeft and error handling
$bestellingHandler = new BestellingsDataHandler();
if ($bestellingHandler->bestellingToegevoegd($broodjeId, $gebruikerId)) {
    $_SESSION['error'] = "Deze gebruiker heeft dit broodje al besteld.";
    header("Location: index.php");
    exit;
}

// bouw Bestelling-object
$bestelling = Bestelling::create(
    null,
    $broodjeId,
    $gebruikerId,
    $gekozen,  // gekozen datum
    $statusId
);

// toevoegen
$bestellingHandler->addBestelling($bestelling);

$_SESSION['success'] = "Bestelling geplaatst voor {$voornaam} {$achternaam}, afhaling op " . $gekozen->format('d-m-Y H:i');
header("Location: index.php");
exit;

