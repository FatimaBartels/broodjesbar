<?php
declare(strict_types=1);


require_once 'BestellingsDataHandler.php';


$bestellingHandler = new BestellingsDataHandler();


$bestellingen = $bestellingHandler->getBestellingsList();

?>

    <link rel="stylesheet" href="css/style.css"> 

   
            
    <div class="container">
         <h3>Bestellingen Overzicht </h3>  
            <table>
                <thead>
                    <tr>
                        <th>Gebruiker</th>
                        <th>Broodje</th>
                        <th>Datum</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($bestellingen as $bestelling): ?> 
                    <tr>
                        <td><?= $bestelling->getGebruiker()->getNaam() ?></td>
                        <td><?= $bestelling->getBroodje()->getNaam() ?></td>
                        <td><?= $bestelling->getDatum()->format('d-m-Y H:i'); ?></td>
                        <td><a href="delete-bestelling.php?id=<?= $bestelling->getId() ?> "><img src="images/delete.png" class="icon-delete"></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    

