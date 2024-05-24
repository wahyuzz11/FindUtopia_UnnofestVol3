<?php
session_start();
$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}

require_once("class/itemLost.php");
require_once("class/itemFounds.php");
$idUser = $_GET['user'];

$itemFound = new ItemFound();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>My Found Items</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .disabledLink.disabled {
            pointer-events: none;
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

        <h1 class="h1 mb-3 text-center">My Found Items</h1>
        <br>
        <div class="accordion" id="accordionParent">
            <?php

            $result = $itemFound->queryItemFoundUser($idUser);
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $imageId = $row['id'];
                $imageExt = $row['ext'];
                if ($row['ext'] == "") {
                    $imageId = "noImage";
                    $imageExt = "png";
                }


                $idUserFound = $idUser;
                $namaItemFound = $row['itemName'];
                $locationFound = $row['idlocation'];
                $categoryFound = $row['idItemCategory'];
                $resultInner = $itemFound->Matching($idUserFound, $namaItemFound, $categoryFound, $locationFound);

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
                echo "<img src='found_images/" . $imageId . "." . $imageExt . "' class='card-img-top img-thumbnail'";
                echo "alt='Lost Image'>";
                echo "</div>";
                echo "<div class='col-sm-6 order-sm-1'>";
                echo "<h4 class='card-title'>" . $row['itemName'] . "</h5>";
                echo "<p class='card-text'>" . $row['description'] . "</p>";
                $class1 = "";
                $class2 = "";
                $style = "";
                $style2 = "";
                if ($row['status_titip'] == 0) {
                    $class = "#exampleModal_" . $id."'";
                    $class2 = "#exampleModalCenter_$id'";
                }else{
                    echo "<div>";
                    echo "<strong> Note : </strong>";
                    echo "<p>This item has been entrusted to findutopia , once our administration has confirmed the item has been returned to the owner this item will gone from your found item list </p>";
                    echo "</div>";
                    $class = "#exampleModalCenter_titip_$id'";
                    $style = "style='background-color:#a6a6a6;'";
                    $class2 = "#exampleModalCenter_titip_$id' ";
                    $style2 = "style='background-color:#a6a6a6;'";
                    
                }
                echo "<h5 class='card-title'>Similar Lost Items </h5>";
                echo "<ul class='list-group list-group-flush'>";
                if ($resultInner->num_rows != 0) {
                    while ($rowInner = $resultInner->fetch_assoc()) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                        echo "<span>" . $rowInner['itemName'] . "</span>";
                        echo "<a class='btn btn-secondary flex-end' href='lihatitemlost.php?id=" . $rowInner['id'] . "'>Check Item</a>";
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
                echo "<a class='w-100 btn btn-lg btn-primary' href='lihatitemfounds.php?id=" . $row['id'] . "'>Detail</a>";
                echo "</div>";

               
                
                echo "<div id ='modalBtn' class='card-body' data-bs-toggle='modal' data-bs-target='";
                echo $class.">";
                echo "<a class='w-100 btn btn-lg btn-primary' ";
                echo ">Entrust This Item To Us</a>";
                echo "</div>";

                echo '<div class="modal fade" id="exampleModal_' . $id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h1 class="modal-title fs-5" id="exampleModalLabel">Entrust Your Items</h1>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';

                echo '<div class="modal-body">';
                echo "<p><b>Important ! </b></p>";
                echo "<p>If You wanted to entrust this item to FindUtopia , Please enter the address correctly as your address information cannot be changed </p>";
                echo '<form action="insertaddress.php" method="GET">';

                echo '<div class="mb-3">';
                echo '<label for="message-text" class="col-form-label">Address:</label>';
                echo '<textarea class="form-control" name="address" id="message-text"></textarea>';
                echo "<input type='hidden' name='idFound' value=$id>";
                echo "<input type='hidden' name='idUser' value=$idUser>";
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                echo '<input type="submit" value="Send Address" name="submit" class="btn btn-primary">';
                echo '</div>';
                echo '</div>';
                echo '</form>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
                echo '</div>';


                echo "<div id ='modalBtn' class='card-body' data-bs-toggle='modal' data-bs-target='";
                echo $class2.">";
                echo "<a class='w-100 btn btn-lg btn-primary'>This Item Has Been Returned To Its Owner</a>";
                echo "</div>";

                //     echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                //     Launch demo modal
                //   </button>';
                // modal 

                echo "<div class='modal fade' id='exampleModalCenter_$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>";
                echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='exampleModalLongTitle' style='color: red;'> <strong>DISCLAMMER : Honest Notice </strong></h5>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "
                <strong>By clicking 'This Item Has Been Returned To Its Owner,' you affirm that you are returning the found item to its rightful owner. Dishonest or misleading actions may result in legal consequences as per applicable laws. Please ensure that the item is being returned to its rightful owner, and false claims may lead to legal liabilities.
                Your honesty and integrity in this matter are greatly appreciated. Thank you</strong>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-primary'><a class='w-100 btn btn-lg' href='updateitemfound.php?user=$idUser&id=$id'>Confirm</a></button>";
                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'><a class='w-100 btn btn-lg'>Close</a></button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";


                echo "<div class='modal fade' id='exampleModalCenter_titip_$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>";
                echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='exampleModalLongTitle'>Important Messages </h5>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "You cannot send a new address nor claim the items has already returned to its owner as the items has already entrusted to FindUtopia. For more
                information and support regarding this item please contact FindUtopia admin: ";
                echo "<b> +62-821-4471-4882 </b>";
                echo "</div>";
                echo "<div class='modal-footer'>";
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
            ?>
        </div>

    </div>

    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>