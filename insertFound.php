<?php
require_once("class/ItemCategories.php");
require_once("class/locations.php");
require_once("class/itemFounds.php");

session_start();
$id = $_SESSION['idUser'];
$nama = $_SESSION['namaUser'];
if ($id == "") {
    header("location: index.php");
}

if (isset($_POST['kirim'])) {

    $namaBarang = $_POST['itemsName'];
    $desc = $_POST['description'];
    $tanggal = $_POST['tanggal'];
    $noHp = $_POST['noHp'];
    $kategori = $_POST['category'];
    $lokasi = $_POST['location'];

    $itemsFound = new ItemFound();

    $foto = $_FILES['foto'];
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);

    $noHp = preg_replace("/[^0-9+]/", "", $noHp);

    // Validate the phone number format
    if (preg_match("/^\+62\d{7,}$/", $noHp)) {
        $new_id = $itemsFound->insert($namaBarang, $desc, $tanggal, $noHp, $kategori, $lokasi, $id, $nama, $ext);

        $dst = "found_images/$new_id.$ext";
        move_uploaded_file($foto['tmp_name'], $dst);


        echo '<div class="modal modal-sheet d-block" tabindex="-1" role="dialog" id="modalSheet">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content rounded-4 shadow">';
        echo '<div class="modal-header border-bottom-0">';
        echo '<h1 class="modal-title fs-5">Report Success</h1>';
        echo '</div>';
        echo '<div class="modal-body py-0">';
        echo '<p>Your report about found item has been successfully added into the database.</p>';
        echo '</div>';
        echo '<div class="modal-footer flex-column border-top-0">';
        echo '<a href="home.php" class="btn btn-lg btn-primary w-100 mx-0 mb-2">Back to Home</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="modal modal-sheet d-block" tabindex="-1" role="dialog" id="modalSheet">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content rounded-4 shadow">';
        echo '<div class="modal-header border-bottom-0">';
        echo '<h1 class="modal-title fs-5">Report Failed</h1>';
        echo '</div>';
        echo '<div class="modal-body py-0">';
        echo '<p>Please input phone number with a valid format!</p>';
        echo '</div>';
        echo '<div class="modal-footer flex-column border-top-0">';
        echo '<a href="insertFound.php" class="btn btn-lg btn-primary w-100 mx-0 mb-2">Back</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Report Found Item</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">FindUtopia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
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
                        <a class="nav-link active" aria-current="page"
                            href="userslostitemlist.php?user=<?php echo $id ?>">Find My Lost Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contactus.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="javascript:void(0)" id="logout"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container-fluid">

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

        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <h1 class="h1 mb-3 text-center">Report Found Item</h1>
            <br>
            <div class="mb-3 col-md-6">
                <label for="floatingItemsName">Item Name</label>
                <input type="text" class="form-control" id="floatingItemsName" name="itemsName" required autofocus>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingTanggal">Date</label>
                <input type="date" class="form-control" id="floatingTanggal" name="tanggal"
                    max="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3 col-md-12">
                <label for="floatingDescription">Description</label>
                <textarea type="text" class="form-control" id="floatingDescription" name="description"
                    required></textarea>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingContact">Contact Number</label>
                <input type="tel" class="form-control" id="floatingContact" name="noHp" pattern="\+\d{10,14}"
                    placeholder="+62 Format" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingImage">Item Image</label>
                <input type="file" class="form-control" id="floatingImage" name="foto" accept="image/*">
            </div>
            <div class="col-md-6">
                <label for="floatingImage">Item Category</label>
                <?php


                $category = new ItemCategories();

                $resCategory = $category->query();
                echo "<select class='form-select form-select-lg mb-3' name='category'>";
                while ($row = $resCategory->fetch_assoc()) {
                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                }
                echo "</select> <br> ";

                ?>
            </div>
            <div class="col-md-6">
                <label for="floatingImage">Found Location</label>
                <?php
                require_once("class/ItemCategories.php");
                require_once("class/locations.php");
                require_once("class/itemFounds.php");
                $locations = new locations();
                $resLocations = $locations->query();

                echo "<select class='form-select form-select-lg mb-3' name='location'>";
                while ($row = $resLocations->fetch_assoc()) {
                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                }
                echo "</select>";
                ?>
            </div>

            <div>
                <h6>
                    Important !
                </h6>
                <p>
                Thank you for reporting the found item. If the item you found has been successfully returned to its owner, please click the <b>This item has been returned to its owner</b>button in My Found Items page. This action will assist us in updating the status and ensuring accurate information within our community
                </p>
            </div>


            <input class="w-100 btn btn-lg btn-primary" type="submit" name="kirim" value="Submit Data">
        </form>
    </div>
    <!-- <form method="POST" enctype="multipart/form-data">
        <label>Nama Barang : </label><input type="text" name="itemsName" required autofocus><br>
        <label>Description : </label><textarea name="description" cols="30" rows="10"></textarea><br>
        <label>Tanggal : </label><input type="date" name="tanggal"><br>
        <label>No Hp : </label><input type="text" name="noHp"><br>
        <?php
        // require_once("class/ItemCategories.php");
        // require_once("class/locations.php");
        // require_once("class/itemFounds.php");
        
        // $category = new ItemCategories();
        // $locations = new locations();
        
        // $resCategory = $category->query();
        // $resLocations = $locations->query();
        
        // echo "<label>Kategori Barang </label> <select name='category'>";
        // while ($row = $resCategory->fetch_assoc()) {
        //     echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
        // }
        // echo "</select> <br> ";
        
        // echo "<label>Lokasi Barang </label> <select name='location'>";
        // while ($row = $resLocations->fetch_assoc()) {
        //     echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
        // }
        // echo "</select>";
        
        ?>
        Foto Barang: <input type="file" name="foto" accept="image/*"><br>
        <input type="submit" name="kirim" value="Submit Data"><br>

    </form> -->

    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>