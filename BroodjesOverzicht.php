<?php
declare(strict_types=1);


require_once 'BroodjesDataHandler.php';


$broodjeHandler = new BroodjesDataHandler();
$broodjes = $broodjeHandler->getBroodjesList();

?>

    <link rel="stylesheet" href="css/style.css"> 

   
  
    <div class="container">
        <h1>Broodjesbar</h1> 
         <h3>Overzicht van alle broodjes </h3>  
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Omschrijving</th>
                        <th>Prijs</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($broodjes as $broodje): ?> 
                    <tr>
                        <td><?= $broodje->getNaam(); ?></td>
                        <td><?= $broodje->getOmschrijving() ?></td>
                        <td>€ <?= $broodje->getPrijs(); ?></td>
                        <td><a href="UpdateBroodForm.php?id=<?= $broodje->getId() ?> "><img src="images/edit.png" class="icon"></a> <span> | </span> <a href="Delete-brood.php?id=<?= $broodje->getId() ?> "><img src="images/delete.png" class="icon"></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Brood Toevoegen</h2>
            <form action="Add-brood.php" method="post">
                <label>
                    Naam: <input type="text" name="Naam" required/>
                </label>
                <br />
                <br />
                <label>
                    Omschrijving: <input type="text" name="Omschrijving" required/>
                </label>
                <br />
                <br />
                <label>
                    Prijs: € <input type="text" name="Prijs"  required /> 
                </label>
                <br/>
                <input type="submit" class="btn" name="toevoegen" value="Toevoegen">
            </form>
    </div>