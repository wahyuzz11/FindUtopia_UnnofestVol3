<?php
require_once("class/itemLost.php");
require_once("class/itemFounds.php");
$idUser = $_GET['user'];
session_start();
$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}
$itemLost = new ItemLost();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Find My Lost Items</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .btnExtends{
            margin-top: 10px;
            margin: bottom 10px;
        }
        .btnExtends:hover{
            opacity: 0.7;
           
        }

        .whatsappBtn:hover{
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand">FindUtopia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Report
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="insertLost.php">Report Lost Item</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="insertFound.php">Report Found Item</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="listFound.php">Found Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="usersfounditemlist.php?user=<?php echo $idUser ?>">My Found Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="userslostitemlist.php?user=<?php echo $idUser ?>">Find My Lost Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contactus.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="javascript:void(0)" id="logout" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>

    <div class="container-fluid">

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Log Out</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id='btnLogout'>Log Out</button>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="h1 mb-3 text-center">My Lost Items</h1>
        <br>
        <div class="accordion" id="accordionParent">
            <?php

            if(isset($_GET['id'])){
                $itemLost->UpdateItem($id);
            }
        
            $result = $itemLost->queryItemLostUser($idUser);
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $imageId = $row['id'];
                $imageExt = $row['ext'];
                if ($row['ext'] == "") {
                    $imageId = "noImage";
                    $imageExt = "png";
                }

                $idUserLost = $idUser;
                $namaItemLost = $row['itemName'];
                $locationLost = $row['idlocation'];
                $categoryLost = $row['idItemCategory'];
                // $lostItem = $_GET['lost'];
                $itemLost = new ItemLost();
                $resultInner = $itemLost->Matching($idUserLost, $namaItemLost, $categoryLost, $locationLost);
                
                echo "<div class='accordion-item'>";
                echo "<h2 class='accordion-header' id='heading" . $row['id'] . "'>";
                echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse'";
                echo "data-bs-target='#collapse" . $row['id'] . "' aria-expanded='true' aria-controls='collapse" . $row['id'] . "'>";
                echo "" . $row['itemName'] . "";
                echo "</button>";
                echo "</h2>";
                echo "<div id='collapse" . $row['id'] . "' class='accordion-collapse collapse' data-bs-parent='#accordionParent'>";
                echo "<div class='accordion-body'>";
                echo "<div class='card'>";
                echo "<div class='row card-body'>";
                echo "<div class='col-sm-6 order-sm-2'>";
                echo "<img src='lost_images/" . $imageId . "." . $imageExt . "' class='card-img-top img-thumbnail'";
                echo "alt='Lost Image'>";
                echo "</div>";
                echo "<div class='col-sm-6 order-sm-1'>";
                echo "<h4 class='card-title'>" . $row['itemName'] . "</h5>";
                echo "<p class='card-text'>" . $row['description'] . "</p>";
                if($row['days_diff'] > 7){
                    echo "<h6 class='card-title'>Your priority post has been expired want to extend it ? </h6>";
                    echo "<p class = 'btnExtends'style='background-color: #FFFF66 ;display:inline-block;border-radius:10px;'>";
                    echo "<a class='btn btn-lg' href='pembayaran.php?idLost=$id'>Extends</a>";
                    echo "</p>";
                }

                if(is_null($row["status"])){
                    echo "<h6 class='card-title'>Want to buy the priority feature ?</h6>";
                    echo "<p class = 'btnExtends'style='background-color: #7FFF7F ;display:inline-block;border-radius:10px;'>";
                    echo "<a class='btn btn-lg' href='pembayaran.php?idLost=$id'>Buy</a>";
                    echo "</p>";
                }else{
                    if($row["status"] == "invalid"){
                        echo "<h6 class='card-title'>Your priority order is invalid , please contact FindUtopia through the number below </h6>";

                        echo "<p class='whatsappBtn' style='background-color: #25D366;display:inline-block;border-radius:6px;'>";
                        echo "<a class='btn btn-lg' href='https://wa.me/6282144714882'>Chat Whatsapp</a>";
                        echo "</p>";
                    }
                }

                echo "<h5 class='card-title'>Similar Found Item</h5>";
                echo "<ul class='list-group list-group-flush'>";
                if ($resultInner->num_rows != 0) {
                    while ($rowInner = $resultInner->fetch_assoc()) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                        echo "<span>" . $rowInner['itemName'] . "</span>";
                        echo "<a class='btn btn-secondary flex-end' href='lihatitemfounds.php?id=" . $rowInner['id'] . "'>Check Item</a>";
                        echo "</li>";
                    }
                } else {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                    echo "<span>No similar item found</span>";
                    echo "</li>";
                }
                echo "</ul>";

                echo "</div>";
                echo "</div>";
                echo "<div class='card-body'>";
                echo "<a class='w-100 btn btn-lg btn-primary' href='lihatitemlost.php?id=" . $row['id'] . "'>Detail</a>";
                $id = $row['id'];
                echo "</div>";

                echo "<div id ='modalBtn' class='card-body' data-bs-toggle='modal' data-bs-target='#exampleModalCenter_$id'>";
                echo "<a class='w-100 btn btn-lg btn-primary'>This item has been found</a>";
                echo "</div>";

                //     echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                //     Launch demo modal
                //   </button>';
                // modal 

                echo "<div class='modal fade' id='exampleModalCenter_$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>";
                echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='exampleModalLongTitle'>Are you sure you want to mark your item as already been found?</h5>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "
                Once you confirm, the status of your item will be updated as found, and it will no longer be listed as lost. 
                Please ensure that you have indeed found your item before proceeding";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-primary'><a class='w-100 btn btn-lg' href='updateitemlost.php?user=$idUser&id=$id'>Confirm</a></button>";
                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'><a class='w-100 btn btn-lg'>Close</a></button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "</div>";

                echo "</div>";

                echo "</div>";
                echo "</div>";
            }

            // while ($row = $result->fetch_assoc()) {
            //     $id = $row['id'];
            //     $imageId = $row['id'];
            //     $imageExt = $row['ext'];
            //     if ($row['ext'] == "") {
            //         $imageId = "noImage";
            //         $imageExt = "png";
            //     }

            //     echo "<div class='accordion-item'>";
            //     echo "<h2 class='accordion-header' id='heading" . $row['id'] . "'>";
            //     echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse'";
            //     echo "data-bs-target='#collapse" . $row['id'] . "' aria-expanded='true' aria-controls='collapse" . $row['id'] . "'>";
            //     echo "" . $row['itemName'] . "";
            //     echo "</button>";
            //     echo "</h2>";
            //     echo "<div id='collapse" . $row['id'] . "' class='accordion-collapse collapse' data-bs-parent='#accordionParent'>";
            //     echo "<div class='accordion-body'>";
            //     echo "<div class='card'>";
            //     echo "<img src='lost_images/" . $imageId . "." . $imageExt . "' class='card-img-top img-thumbnail'";
            //     echo "alt='Lost Image'>";
            //     echo "</div>";
            //     echo "<div class='card-body'>";
            //     echo "<h5 class='card-title'>" . $row['itemName'] . "</h5>";
            //     echo "<p class='card-text'>" . $row['description'] . "</p>";
            //     echo "</div>";
            //     echo "<ul class='list-group list-group-flush'>";
            //     echo "<li class='list-group-item'>Date: " . date("d F Y", strtotime($row['date'])) . "</li>";
            //     echo "<li class='list-group-item'>Contact: " . $row['noHp'] . "</li>";
            //     echo "<li class='list-group-item'>Category: " . $row['category'] . "</li>";
            //     echo "<li class='list-group-item'>Location: " . $row['location'] . "</li>";
            //     echo "</ul>";
            //     echo "<a class='w-100 btn btn-lg btn-primary' href='finditemlost.php?user=$idUser&lost=$id&item=" . $row['itemName'] . "&location=" . $row['idlocation'] . "&category=" . $row['idItemCategory'] . "'>Find My Item</a>";
            //     echo "</div>";
            //     echo "</div>";
            //     echo "</div>";
            // }
            ?>
        </div>

    </div>

    <!-- <div id="container">
        <?php
        // require_once("class/itemLost.php");
        // require_once("class/itemFounds.php");
        // $idUser = $_GET['user'];

        // $itemLost = new ItemLost();
        // $result = $itemLost->queryItemLostUser($idUser);


        // while ($row = $result->fetch_assoc()) {
        //     echo "<div class='card' id='c-" . $row['id'] . "'>";
        //     $id = $row['id'];
        //     echo "<img src= 'lost_images/" . $row['id'] . "." . $row['ext'] . "' width='200px' alt='" . $row['itemName'] . "'>";
        //     echo "<p class='namaItem'>" . $row['itemName'] . "</p>";
        //     echo "<p class='tglItem'>" . date("d F Y", strtotime($row['date'])) . " </p>";
        //     echo "<br>";
        //     echo "<div id='btnContainer'>";
        //     echo "<a href='finditemlost.php?user=$idUser&lost=$id&item=" . $row['itemName'] . "&location=" . $row['location'] . "&category=" . $row['category'] . "'>";
        //     echo "<button class='btnValidasi'>Cari Barang Saya</button>";
        //     echo "</a>";
        //     echo "</div>";
        //     echo "</div>";
        // }

        ?>
    </div> -->

    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>