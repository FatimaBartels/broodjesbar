<?php

declare(strict_types = 1);

require_once 'GebruikersDataHandler.php';
require_once 'BroodjesDataHandler.php';


$listGebruiker = new GebruikersDataHandler();
$gebruikers = $listGebruiker->getGebruikersList();


$listBroodje = new BroodjesDataHandler();
$broodjes = $listBroodje->getBroodjesList();
session_start();

?>


    <link rel="stylesheet" href="css/style.css"> 
   

    <div class="container">
        <h1>Broodjesbar</h1>

        <?php if (isset($_SESSION['success'])): ?>
        <p class="success-message"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

       
        <form action="Add-bestelling.php" method="post" class="bestel-form">
       
         <h4>Kies gebruiker</h4>

            <label for="gebruiker">Gebruiker:</label>
            <select id="gebruiker" name="gebruikerId"  required>
                <option value="">.. Kies Gebruiker ..</option>
                    <?php foreach ($gebruikers as $gebruiker): ?>
                        <option value="<?= $gebruiker->getId(); ?>">
                            <?= $gebruiker->getNaam(); ?> 
                        </option>
                    <?php endforeach; ?>
            </select>
    

        
       
            <h4>Kies jouw brood hier: </h4>
            <table>
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
                            <td><input type="radio" name="broodjeId" value="<?= $brood->getId(); ?>" required>
                             <?= $brood->getNaam() ?> </td>
                            <td><?= $brood->getOmschrijving() ?></td>
                            <td>€ <?= $brood->getPrijs() ?></td>
                        </tr>
                
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn">Bestel</button>
      
        </form>
  </div>




    
