<?php
require_once("class/itemLost.php");
session_start();

$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}
// $idLost = $_COOKIE['id'];
$idLost = "";
if(isset($_SESSION['newId'])){
    $idLost = $_SESSION['newId'];
}

if(isset($_GET['idLost'])){
    $idLost = $_GET['idLost'];
}

// echo $idLost;
// unset($_COOKIE['id']);
if (isset($_POST['bayar'])) {
    $noRek = $_POST['noRekening'];
    $bank = $_POST['bank'];
    $bukti = $_FILES['bukti'];
    $ext = pathinfo($bukti['name'], PATHINFO_EXTENSION);
    $itemLost = new ItemLost();
    $currentDateTime = new DateTime();
    $formattedDateTime = $currentDateTime->format('Y-m-d');

    $itemLost->insertPriority($idLost, $noRek, $bank, $ext, $formattedDateTime);
    $dst = "priority/$idLost.$ext";
    move_uploaded_file($bukti['tmp_name'], $dst);

    echo '<div class="modal modal-sheet d-block" tabindex="-1" role="dialog" id="modalSheet">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content rounded-4 shadow">';
    echo '<div class="modal-header border-bottom-0">';
    echo '<h1 class="modal-title fs-5">Report Payment Success</h1>';
    echo '</div>';
    echo '<div class="modal-body py-0">';
    echo '<p>Your report about lost item has been successfully added into the database.</p>';
    echo '</div>';
    echo '<div class="modal-footer flex-column border-top-0">';
    echo '<a href="home.php" class="btn btn-lg btn-primary w-100 mx-0 mb-2">Back to Home</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Payment</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <link href="css\form-validation.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4 w-50" src="src_images\shield_search_find_business_logo.svg" alt="logo"
                    width="128" height="128">
                <h2>Payment</h2>
                <p class="lead">Thank you for choosing our services! To complete your payment, transfer the total amount
                    of <b>Rp 5.000,00</b> to our Bank Central Asia (BCA) account with the following details: Account
                    Name
                    <b>Komang Wahyu Sri Adijaya</b>, Account Number <b>239938454</b>. Include the <b>Item ID
                        <?php echo $idLost ?>
                    </b>
                    with your transfer. Afterward, screenshot the proof of payment and add it to the form below.
                </p>
            </div>

            <div class="row g-5">
                <div>
                    <h4 class="mb-3">Report Payment</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="NoRekening" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="NoRekening" name="noRekening" placeholder=""
                                    required>
                            </div>

                            <div class="col-sm-6">
                                <label for="Bukti" class="form-label">Payment Screenshot</label>
                                <input type="file" class="form-control" id="Bukti" name="bukti" accept="image/*"
                                    required>
                            </div>

                            <div class="col-sm-12">
                                <label for="Bank" class="form-label">Bank</label>
                                <input type="text" class="form-control" id="Bank" name="bank" placeholder="" value=""
                                    required>
                            </div>

                            <hr class="my-4">

                            <input class="w-100 btn btn-primary btn-lg" type="submit" name="bayar"
                                value="Confirm Payment">
                    </form>
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2023 FindUtopia</p>
        </footer>
    </div>
    <!-- <form method="POST" enctype="multipart/form-data">
        <label>No Rekening : </label> <input type="text" name="noRekening"><br>
        <label>Bank : </label> <input type="text" name="bank"><br>
        <label>Bukti Pembayaran </label><br><input type="file" name="bukti" accept="image/*"><br>
        <input type="submit" name="bayar" value="submit">
    </form> -->
    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script src="js\form-validation.js"></script>
</body>

</html>