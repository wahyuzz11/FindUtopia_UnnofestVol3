<?php
 require_once("class/itemLost.php");
 require_once("class/itemFounds.php");
 $itemFound = new ItemFound();

if(isset($_GET['id'])){
    $idFound = $_GET['id'];
    $itemFound->updateAddress($idFound);
    header("Location: pickupaddress.php");

}

















?>