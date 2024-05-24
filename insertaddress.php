<?php

require_once("class/itemLost.php");
require_once("class/itemFounds.php");

$itemFound = new ItemFound();

if(isset($_GET['submit'])){
    echo "1";
    if(isset($_GET['address']) && isset($_GET['idFound']) && isset($_GET['idUser'])){
        $address = $_GET["address"];
        $idFound = $_GET["idFound"];
        $idUser = $_GET["idUser"];
        
        $itemFound->insertPickUpAddress($address, $idFound);
         
    }

    header("Location: usersfounditemlist.php?user=$idUser");
}





















?>