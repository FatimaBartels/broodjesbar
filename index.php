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
                            <td><input type="radio" name="broodjeId" value="<?= $brood->getBroodId(); ?>" required>
                             <?= $brood->getBroodNaam() ?> </td>
                            <td><?= $brood->getOmschrijving() ?></td>
                            <td>€ <?= $brood->getPrijs() ?></td>
                        </tr>
                
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h4>Vul jouw gegevens hier</h4>
          
                    <label for="voornaam">Voornaam:</label>
                    <input type="text" name="voornaam" required>
                    <br/>
                    <label for="achternaam">Achternaam:</label>
                    <input type="text" name="achternaam" required>
                    <br/>
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" required>
                    <br/>
                    <br/>
                    <label for="tijdstip">Afhaalmoment:</label>
                    <input type="datetime-local" name="tijdstip" class="tijd" required>
                     <br/>
            
                    <button type="submit" class="btn">Bestellen</button>
      
        </form>
  </div>




    
