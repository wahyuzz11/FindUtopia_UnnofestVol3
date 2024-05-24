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
    <title>Verifikasi Data</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <link href="css/button-animation.css" rel="stylesheet">
    <link href="css\carousel.css" rel="stylesheet">
    <style type="text/css">
        p {
            font-family: Arial, Helvetica, sans-serif;
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
                        <a class="nav-link active" aria-current="page" href="admin.php">Order Priority Verification</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pickupaddress.php">Pick Up Item Founds Address List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="javascript:void(0)" id="logout" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Log Out</a>
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
    <?php
    require_once("class/itemLost.php");
    require_once("class/itemFounds.php");
    $itemFound = new ItemFound();

    $perpage = 8;
    $totalData = $itemFound->QueryAddressNoLimit()->num_rows;
    $jumlahPage = ceil($totalData / $perpage);

    //SELECT WITH LIMIT
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    } else {
        $p = 1;
    }

    if (!is_numeric($p))
        $p = 1;

    $startPage = ($p - 1) * $perpage;
    $result = $itemFound->QueryAddressWithLimit($startPage, $perpage);

    echo "<div class='table-responsive mx-auto'>";
    echo "<table border='1'class='table table-hover table-sm '>";
    echo "<thead class='table-active'>";
    echo "<tr>";
    echo "<th scope='col' class='text-center'>#</th>";
    echo "<th scope='col' class='text-center'>Item Name</th>";
    echo "<th scope='col' class='text-center'>Date</th>";
    echo "<th scope='col' class='text-center'>Contact Information</th>";
    echo "<th scope='col' class='text-center'>Id User</th>";
    echo "<th scope='col' class='text-center'>Item Founder Name</th>";
    echo "<th scope='col' class='text-center'>Pick Up Addres</th>";
    echo "<th scope='col' class='text-center'>Already Picked Up ?</th>";
    echo "</tr>";
    echo "</thead>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        $id = $row['id'];
        echo "<td class='text-center'>" . $id . "</td>";
        echo "<td class='text-left'>" . $row['name'] . "</td>";
        echo "<td class='text-center'>" . date("d F Y", strtotime($row['date'])) . "</td>";
        echo "<td class='text-center'>" . $row['noHp'] . "</td>";
        echo "<td class='text-center'>" . $row['idUser'] . "</td>";
        echo "<td class='text-center'>" . $row['nama'] . "</td>";
        echo "<td class='text-center'>" . $row['alamat'] . "</td>";
        echo "<td class='text-center'><button type='button' class='btn btn-info btn-sm btn-change' onclick='location.href=\"updateaddress.php?id=$id\"'>Yes</button></td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<br>";
    echo "<nav aria-label='...'>";
    echo "<ul class='pagination justify-content-center'>";
    echo "<li class='page-item'><a class='page-link'href='admin.php?p=1'>First</a></li>";
    if ($p != 1) {
        $prev = $p - 1;
        echo "<li class='page-item' ><a class='page-link' href='admin.php?p=$prev'>Prev</a></li>";
    }
    for ($i = 1; $i <= $jumlahPage; $i++) {
        $activeClass = ($i == $p) ? 'active' : '';
        echo "<li class='page-item $activeClass'><a  class='page-link' aria-current='page' href='admin.php?p=$i'>$i</a></li>";
    }
    if ($p != $jumlahPage) {
        $next = $p + 1;
        echo "<li class='page-item'><a class='page-link' href='admin.php?p=$next'>Next</a></li>";
    }
    echo "<li class='page-item'><a class='page-link' href='admin.php?p=$jumlahPage'>Last</a></li>";
    echo "</ul>";
    echo "</div>";
    ?>
    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>