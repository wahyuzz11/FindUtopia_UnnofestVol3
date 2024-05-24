<?php
require_once("class/itemLost.php");
require_once("class/itemFounds.php");

$itemLost = new ItemLost();


if(isset($_GET["id"]) && isset($_GET['user'])){
    $idUser = $_GET['user'];
    $id = $_GET['id'];
    $itemLost->UpdateItem($id);

    header("Location: userslostitemlist.php?user=$idUser");

}


























?>