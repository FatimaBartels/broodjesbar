<?php
declare(strict_types=1);


require_once 'BestellingsDataHandler.php';
require_once 'StatussenDataHandler.php';


$statusHandler = new StatussenDataHandler();

$bestellingHandler = new BestellingsDataHandler();
$bestellingen = $bestellingHandler->getBestellingsList();

$statusCache = [];

function getStatusNaam(StatussenDataHandler $handler, array &$cache, int $statusId): string {
    if (!isset($cache[$statusId])) {
        $cache[$statusId] = $handler->getStatusById($statusId);
    }
    return $cache[$statusId] ? $cache[$statusId]->getStatus() : 'Onbekend';
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Besteloverzicht</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>

   
<body>
    <div class="container">
        <h1>Broodjesbar</h1> 
         <h3>Overzicht van de bestellingen </h3>  
            <table>
                <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Naam</th>
                        <th>Broodje</th>
                        <th>Afhalingsmoment</th>
                        <th>Status</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bestellingen as $bestelling): ?>
                      <?php

                        // status object
                        $statusId = $bestelling->getStatusId();
                        if (!isset($statusCache[$statusId])) {
                            $statusCache[$statusId] = $statusHandler->getStatusById($statusId);
                        }
                        $statusObj = $statusCache[$statusId];
                        $statusNaam = $statusObj ? $statusObj->getStatus() : 'Onbekend';

                        $gebruiker = $bestelling->getGebruiker();
                        $broodje = $bestelling->getBroodje();
                    ?> 
                    <?php $rowClass = strtolower(trim($statusNaam)); ?>
                    <tr class="<?= $rowClass ?>">
                        <td><?= $gebruiker->getGebruikerVoorNaam() ?></td>
                        <td><?= $gebruiker->getGebruikerNaam() ?></td>
                        <td><?= $broodje->getBroodNaam() ?></td>
                        <td><?= $bestelling->getDatum()->format('d-m-Y H:i'); ?></td>
                        <td><?= $statusNaam ?></td>
                        <td>  

                        <?php
                            $norm = mb_strtolower(trim($statusNaam));
                            ?>
                            <?php if ($norm === 'besteld'): ?>
                                <form method="post" action="update-status.php" >
                                    <input type="hidden" name="id" value="<?= (int)$bestelling->getId() ?>">
                                    <input type="hidden" name="status" value="Gemaakt">
                                    <button type="submit" class="btn">Gemaakt</button>
                                </form>
                            <?php elseif ($norm === 'gemaakt'): ?>
                                <form method="post" action="update-status.php">
                                    <input type="hidden" name="id" value="<?= (int)$bestelling->getId() ?>">
                                    <input type="hidden" name="status" value="Afgehaald">
                                    <a class="btn" id="link" href="delete-bestelling.php?id=<?= $bestelling->getId() ?> ">Afgehaald</a>
                                </form>
                            <?php else: ?>
                                <?= $statusNaam ?>
                            <?php endif; ?>
                    </td>
    
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</body>
    
</html>

