<?php
require_once("class/itemLost.php");
require_once("class/itemFounds.php");


$itemFound = new ItemFound();

if(isset($_GET["id"]) && isset($_GET['user'])){
    $idUser = $_GET['user'];
    $id = $_GET['id'];
    $itemFound->UpdateItem($id);

    header("Location: userslostitemlist.php?user=$idUser");

}

