<?php

declare(strict_types = 1);

require_once 'GebruikersDataHandler.php';
require_once 'BroodjesDataHandler.php';


$listGebruiker = new GebruikersDataHandler();
$gebruikers = $listGebruiker->getGebruikersList();


$listBroodje = new BroodjesDataHandler();
$broodjes = $listBroodje->getBroodjesList();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broodjesbar homepagina</title>
</head>
<body>
    <div class="container">
        <h1>Broodjesbar</h1>
         <h3>Kies Gebruiker</h3>
        <label for="gebruiker">Gebruiker:</label>
        <select id="gebruiker" name="gebruiker"  required>
            <option value="">.. Kies Gebruiker ..</option>
                <?php foreach ($gebruikers as $gebruiker): ?>
                    <option value="<?= $gebruiker->getId(); ?>">
                        <?= $gebruiker->getNaam(); ?> 
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

     <h3>Kies jouw brood hier: </h3>
    <div class="container">
        <table border="1">
            <thead>
                <tr>
                    <th>Brood Naam</th>
                    <th>Omschrijving</th>
                    <th>Prijs</th>

                </tr>
            </thead>
            <tbody>
               <?php foreach ($broodjes as $brood): ?> 
                    <tr>
                        <td><?= $brood->getNaam() ?> </td>
                        <td><?= $brood->getOmschrijving() ?></td>
                        <td><?= $brood->getPrijs() ?></td>
                    </tr>
               
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn-bestel">Bestel</button>
    </div>
  </div>



    
</body>
</html>