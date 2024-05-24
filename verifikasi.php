<?php
require_once("class/itemLost.php");
session_start();
$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}

$id = $_GET["id"];
$itemLost = new ItemLost();
if (isset($_POST)) {

    if (isset($_POST['valid'])) {
        $itemLost->updateOrder($_POST['valid'], $id);
        header("Location: admin.php");
    } else if (isset($_POST['invalid'])) {
        $itemLost->updateOrder($_POST['invalid'], $id);
        header("Location: admin.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Verifikasi Order</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <link href="css/button-animation.css" rel="stylesheet">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background-color: #E3CAA5;
        }

        .valid {
            background: #9ADE7B;
            width: 120px;
            height: 40px;
        }

        .valid.btn-change:hover {
            background: greenyellow;
        }

        .invalid {
            background: #F24C3D;
            width: 120px;
            height: 40px;
        }

        .invalid.btn-change:hover {
            background: red;
        }

        img {
            max-width: 100%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        #container {
            max-width: 722px;
            margin-right: auto;
            margin-left: auto;
            margin-top: 2%;
            margin-bottom: 2%;
        }

        .custom-card {
            background-color: #FFFBE9;
            border: 2px solid #3498db;
            border-radius: 10px;
            width: 720px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .custom-card .card-header {
            background-color: #3498db;
            color: #fff;
        }

        .custom-card .card-title {
            text-align: center;
        }

        .custom-card .card-text {
            color: #555;
            font-weight: bolder;
        }

        .space {
            margin-left: 10%;

        }

        input[type=submit] {
            margin-top: 2%;
            margin-bottom: 2%;
        }

        p {
            font-size: 15px;
            font-family: Arial;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand">FindUtopia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Order Priority Verification</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pickupaddress.php">Pick Up Item Founds
                            Address List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="javascript:void(0)" id="logout"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

    <section id="container">
        <?php
        $result = $itemLost->queryOrder($id);
        if ($row = $result->fetch_assoc()) {
            $idItem = $row['id'];
            $namaUser = $row['nama'];
            $namaItem = $row['name'];
            $noHp = $row['noHp'];
            $date = $row['date'];
            $noRekening = $row['noRekening'];
            $bank = $row['bank'];
            $extension = $row['ext_bukti'];
        }
        echo "<div class='container-fluid'>";
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<div class='card custom-card'>";
        echo "<div class='card-header p-3 mb-2 bg-info text-white '>";
        echo "<h3 class='card-title mb-0'><strong>Verification Data</strong></h3>";
        echo "</div>";
        echo "<div class='card-body'>";
        echo "<label class='h4'>Owner's Name:</label><p>$namaUser</p>";
        echo "<label class='h4'>Phone Number:</label><p>$noHp</p>";
        echo "<label class='h4'>Date:</label><p>" . date('l, j F Y', strtotime($date)) . "</p>";
        echo "<label class='h4'>Bank account number:</label><p>$noRekening</p>";
        echo "<label class='h4'>Bank:</label><p>$bank</p>";
        echo "<h2 class='card-title mb-0 text-muted'><strong>Payment Receipt</strong></h2><br>";
        echo "<img class='card-img-top' src='priority/$idItem.$extension' alt='bukti-pembayaran-$idItem'>";
        echo "<form method='POST'class='d-flex justify-content-center'>";
        echo "<input type ='submit' class='btn valid btn-change' name='valid' value='valid'>";
        echo "<input type ='submit' class='btn invalid space btn-change' name='invalid' value='invalid'>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        // Payment Card
        // echo "<div id='payment'class='col-md-6'>";
        // echo "<div class='card custom-card text-center'>";
        // echo "<div class='card-body'>";
        // echo "<h2 class='card-title mb-0'>Bukti Pembayaran</h2>";
        // echo "<img class='card-img-top' src='priority/$idItem.$extension' alt='bukti-pembayaran-$idItem'>";
        // echo "</div>";
        // echo "</div>";
        // echo "</div>";
        
        // echo "</div>";
        

        ?>
    </section>


    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Order</title>
</head>

<body>

    <div id="container">
        <?php
        // require_once("class/itemLost.php");
        
        // $id = $_GET["id"];
        
        // $itemLost = new ItemLost();
        // $result = $itemLost->queryOrder($id);
        // if ($row = $result->fetch_assoc()) {
        //     $idItem = $row['id'];
        //     $namaUser = $row['nama'];
        //     $namaItem = $row['name'];
        //     $noHp  = $row['noHp'];
        //     $date = $row['date'];
        //     $noRekening = $row['noRekening'];
        //     $bank = $row['bank'];
        //     $extension = $row['ext_bukti'];
        // }
        
        // echo "<div>";
        // echo "Nama Postingan : $namaItem <br>";
        // echo "Nama pemilik barang : $namaUser <br>";
        // echo "No Hp : $noHp <br>";
        // echo "Tanggal : $date <br>";
        // echo "Bukti Pembayaran <br>";
        // echo "<img src= 'priority/$idItem.$extension' alt='bukti-pembayaran-$idItem'> <br>";
        // echo "No Rekening : $noRekening <br>";
        // echo "Bank : $bank <br>";
        

        // echo "<form method='POST'>";
        // echo "<input type ='submit' name='valid' value='valid'>";
        // echo "<input type ='submit' name='invalid' value='invalid'>";
        // echo "</form>";
        
        // if(isset($_POST)){
        
        //     if(isset($_POST['valid'])){
        //         $itemLost->updateOrder($_POST['valid'],$id);
        //         header("Location: admin.php");
        //     }
        //     else if(isset($_POST['invalid'])){
        //         $itemLost->updateOrder($_POST['invalid'],$id);
        //         header("Location: admin.php");
        //     }
        
        // }
        
        // echo "</div>";
        

        ?>
    </div>

</body>

</html> -->