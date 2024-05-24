<?php
require_once("class/ItemCategories.php");
require_once("class/locations.php");
require_once("class/itemLost.php");
session_start();
$id = $_SESSION['idUser'];
if ($id == "") {
    header("location: index.php");
}
?>
<?php

if (isset($_POST['kirim'])) {
    $namaBarang = $_POST['itemsName'];
    $desc = $_POST['description'];
    $tanggal = $_POST['tanggal'];
    $noHp = $_POST['noHp'];
    $kategori = $_POST['category'];
    $lokasi = $_POST['location'];
    $prioritas = $_POST['tipe'];
    $itemsLost = new ItemLost();

    $foto = $_FILES['foto'];
    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);

    $noHp = preg_replace("/[^0-9+]/", "", $noHp);

    // Validate the phone number format
    if (preg_match("/^\+62\d{7,}$/", $noHp)) {
        $new_id = $itemsLost->insert($namaBarang, $desc, $tanggal, $noHp, $kategori, $lokasi, $id, $ext, $prioritas);

        $dst = "lost_images/$new_id.$ext";
        move_uploaded_file($foto['tmp_name'], $dst);



        if ($prioritas == 1) {
            $_SESSION['newId'] = $new_id;
            // setcookie("id", $new_id, time() + 60, "/");
            header("Location: pembayaran.php");
        } else {
            echo '<div class="modal modal-sheet d-block" tabindex="-1" role="dialog" id="modalSheet">';
            echo '<div class="modal-dialog" role="document">';
            echo '<div class="modal-content rounded-4 shadow">';
            echo '<div class="modal-header border-bottom-0">';
            echo '<h1 class="modal-title fs-5">Report Success</h1>';
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
        echo '<a href="insertLost.php" class="btn btn-lg btn-primary w-100 mx-0 mb-2">Back</a>';
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
    <title>Report Lost Item</title>
    <script type="text/javascript" src="javaScript/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="javaScript/insertLost.js"></script>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        #informationBtn {
            cursor: pointer;
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

        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <h1 class="h1 mb-3 text-center">Report Lost Item</h1>
            <br>
            <div class="mb-3 col-md-6">
                <label for="floatingItemsName">Item Name</label>
                <input type="text" class="form-control" id="floatingItemsName" name="itemsName" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingTanggal">Date</label>
                <input type="date" class="form-control" id="floatingTanggal" name="tanggal" max="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3 col-md-12">
                <label for="floatingDescription">Description</label>
                <textarea type="text" class="form-control" id="floatingDescription" name="description" required></textarea>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingContact">Contact Number</label>
                <input type="tel" class="form-control" id="floatingContact" name="noHp" pattern="\+\d{10,14}" placeholder="+62 Format" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="floatingImage">Item Image</label>
                <input type="file" class="form-control" id="floatingImage" name="foto" accept="image/*" required>
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
                <label for="floatingImage">Last Known Location</label>
                <?php
                $locations = new locations();
                $resLocations = $locations->query();

                echo "<select class='form-select form-select-lg mb-3' name='location'>";
                while ($row = $resLocations->fetch_assoc()) {
                    echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                }
                echo "</select>";
                ?>
            </div>
            <div class="col-md-12">
                <div>
                    <label for="floatingImage">Want to featured the item?</label>
                    <label id="informationBtn">
                        <a data-bs-toggle='modal' data-bs-target='#exampleModal'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                        </a>

                    </label>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Introducing the Priority Feature on FindUtopia</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>The Priority Feature is an exclusive offering on FindUtopia's platform, allowing users to boost visibility for their posts at the forefront of the platform. By purchasing this feature for a nominal fee of 5,000 Indonesian Rupiah, users ensure their item listings prominently appear at the top section of the home page.</p>

                                    <b>Key Features:</b>
                                    <br>
                                    <h6> - Enhanced Visibility: The Priority Feature ensures that user posts consistently occupy prime positions on the home page for increased visibility.</h6>
                                    <h6> - Duration and Renewal: Each purchase of the Priority Feature grants a duration of seven days. Users can repurchase this feature once the previous duration expires, maintaining their posts' prominent placement.</h6>
                                    <h6> - Randomized Display: Posts with the Priority Feature are randomized in their display order amongst other prioritized posts. This prevents continuous repetition of the same post at the top position, ensuring fairness and diversity in visibility.</h6>
                                    <h6> - The Priority Feature provides users with a competitive advantage, enabling their posts to receive heightened exposure within the platform's listings. It's a dynamic way to ensure visibility and exposure for items or posts that users wish to emphasize.</h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipe" id="flexRadioDefault1" value="1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipe" id="flexRadioDefault2" value="0" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        No
                    </label>
                </div>
            </div>

            <div>
                <h6>
                    Important !
                </h6>
                <p>
                    Thank you for reporting your lost item. If the item you reported has been found or returned to you, please click the <b>This item has been found</b> button in My Lost Item page. This will help us update the status and provide accurate information to other users.
                </p>
            </div>


            <input class="w-100 btn btn-lg btn-primary" type="submit" style="margin-bottom:2%" name="kirim" value="Submit Data"><br>

        </form>



    </div>
    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>