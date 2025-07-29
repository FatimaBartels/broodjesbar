<?php

declare(strict_types = 1);


require_once 'Bestelling.php';
require_once 'BestellingsDataHandler.php';

if (isset($_POST['broodjeId'], $_POST['gebruikerId'] ) &&
    !empty($_POST['broodjeId']) &&
    !empty($_POST['gebruikerId'])  
    
) {
    session_start();

   
    $broodjeId = (int)$_POST['broodjeId'];
    $gebruikerId = (int)$_POST['gebruikerId'];
  
    
 
        $bestelList = new BestellingsDataHandler();
   
       
        if (!$bestelList->bestellingToegevoegd($broodjeId, $gebruikerId)) {
            $bestelObj = Bestelling::create(null, $broodjeId, $gebruikerId, new DateTime());
            $bestelList->addBestelling($bestelObj);
            $_SESSION['success'] = "Bestelling is toegevoegd.";
        } else {
            $_SESSION['error'] = "Dit persoon heeft al een bestelling gemaakt";
        }
    } else {
        $_SESSION['error'] = "Elke bestelling moet een broodje en gebruiker hebben.";
    }


header("Location: index.php?form=addBestelling");
exit;
