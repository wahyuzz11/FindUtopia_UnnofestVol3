<?php
session_start();
$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Found Item Details</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        #whatsappBtn:hover{
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">FindUtopia</a>
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
                        <a class="nav-link active" aria-current="page" href="usersfounditemlist.php?user=<?php echo $id ?>">My Found Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="userslostitemlist.php?user=<?php echo $id ?>">Find My Lost Item</a>
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

        <h1 class="h1 mb-3 text-center">Found Item Details</h1>
        <div class="container col-xxl-8 px-4 py-5">
            <?php
            require_once("class/itemFounds.php");
            require_once("class/itemLost.php");
            $itemfounds = new ItemFound();
            $itemlost = new ItemLost();

            if (isset($_GET['id'])) {
                // $id = $_GET['found'];
                $id = $_GET['id'];
                if (isset($_GET['lost'])) {
                    $idLost = $_GET['lost'];
                    // $itemfounds->updateItemFounds($id);

                    // $itemlost->updateItemLost($id, $idLost);

                    // $result = $itemfounds->querySingleData($id);
                    // if($row = $result->fetch_assoc()){
                    //     echo "<img src= 'found_images/" .$row['id'].".".$row['ext']. "' width='200px' alt='".$row['itemName']."'>";
                    //     echo "<p>" . $row['itemName'] . "</p>";
                    //     echo "<p>" . $row['description'] . "</td>";
                    //     echo "<p>" . date("d F Y", strtotime($row['date'])) . "</p>";
                    //     echo "<p>" . $row['noHp'] . "</p>";
                    //     echo "<p>" . $row['category'] . "</p>";
                    //     echo "<p>" . $row['location'] . "</p>";
                    // }
                }

                $result = $itemfounds->querySingleData($id);
                if ($row = $result->fetch_assoc()) {
                    $imageId = $row['id'];
                    $imageExt = $row['ext'];
                    if ($row['ext'] == "") {
                        $imageId = "noImage";
                        $imageExt = "png";
                    }
                    echo "<div class='row flex-lg-row-reverse align-items-center g-5 py-5'>";
                    echo "<div class='col-10 col-sm-8 col-lg-6'>";
                    echo "<img src='found_images/" . $imageId . "." . $imageExt . "' class='d-block mx-lg-auto img-fluid' alt='" . $row['name'] . "' width='700'";
                    echo "height='500' loading='lazy'>";
                    echo "</div>";
                    echo "<div class='col-lg-6'>";
                    echo "<h1 class='display-1 fw-bold lh-1 mb-3'>" . $row['name'] . "</h1>";
                    echo "<h2 class='display-6 lh-1 mb-3'> Found By : " . $row['user'] . "</h2>";
                    $namaBarang = "";
                    $namaLokasi = "";

                    if($row['status_titip'] == 0){
                        $namaBarang = $row['name'];
                        $namaLokasi = $row['location'];
                        $noHp = explode("+",$row['noHp']);
                        $phoneNumber = $noHp[1];
                        echo "<h2 class='display-6 lh-1 mb-3'>" . $row['noHp'] . "</h2>";
                        echo "<p id='whatsappBtn' style='background-color: #25D366;display:inline-block;border-radius:6px;'>";
                        echo "<a class='btn btn-lg' href='https://wa.me/$phoneNumber?text=Halo%20Apakah%20benar%20anda%20menemukan%20$namaBarang%20di%20$namaLokasi%20?'>Chat Whatsapp</a>";
                        echo "</p>";
                    }else{
                        echo "<h2 class='display-6 lh-1 mb-3'>+6282144714882</h2>";
                        echo "<p id='whatsappBtn' style='background-color: #25D366;display:inline-block;border-radius:6px;'>";
                        echo "<a class='btn btn-lg' href='https://wa.me/6282144714882?text=Halo%20Saya%20Pemilik Dari%20$namaBarang'>Chat Whatsapp</a>";
                        echo "</p>";
                        echo "<p>This item right now has been entrusted to FindUtopia. You can visit our office at Jalan Rungkut Mejoyo Utara I no 14 or contact whatsapp number above</p>";
                    }
                    
                    echo "<p>" . date("d F Y", strtotime($row['date'])) . "</p>";
                    echo "<p class='lead'>" . $row['description'] . "</p>";
                    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-start'>";
                    echo "<button type='button' class='btn btn-outline-secondary btn-lg px-4 me-md-2 disabled'>" . $row['location'] . "";
                    echo "</button>";
                    echo "<button type='button' class='btn btn-outline-secondary btn-lg px-4 me-md-2 disabled'>" . $row['category'] . "";
                    echo "</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <?php

    // require_once("class/itemFounds.php");
    // require_once("class/itemLost.php");
    // $itemfounds = new ItemFound();
    // $itemlost = new ItemLost();

    // if (isset($_GET['id'])) {
    //     // $id = $_GET['found'];
    //     $id = $_GET['id'];
    //     if (isset($_GET['lost'])) {
    //         $idLost = $_GET['lost'];
    //         $itemfounds->updateItemFounds($id);

    //         $itemlost->updateItemLost($id, $idLost);

    //         // $result = $itemfounds->querySingleData($id);
    //         // if($row = $result->fetch_assoc()){
    //         //     echo "<img src= 'found_images/" .$row['id'].".".$row['ext']. "' width='200px' alt='".$row['itemName']."'>";
    //         //     echo "<p>" . $row['itemName'] . "</p>";
    //         //     echo "<p>" . $row['description'] . "</td>";
    //         //     echo "<p>" . date("d F Y", strtotime($row['date'])) . "</p>";
    //         //     echo "<p>" . $row['noHp'] . "</p>";
    //         //     echo "<p>" . $row['category'] . "</p>";
    //         //     echo "<p>" . $row['location'] . "</p>";
    //         // }
    //     }

    //     $result = $itemfounds->querySingleData($id);
    //     if ($row = $result->fetch_assoc()) {
    //         echo "<img src= 'found_images/" . $row['id'] . "." . $row['ext'] . "' width='200px' alt='" . $row['itemName'] . "'>";
    //         echo "<p>" . $row['itemName'] . "</p>";
    //         echo "<p>" . $row['description'] . "</td>";
    //         echo "<p>" . date("d F Y", strtotime($row['date'])) . "</p>";
    //         echo "<p>" . $row['noHp'] . "</p>";
    //         echo "<p>" . $row['category'] . "</p>";
    //         echo "<p>" . $row['location'] . "</p>";
    //     }

    // }
    ?>
    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>