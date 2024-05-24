<?php
require_once __DIR__ . '/class/itemLost.php';
require_once("class/ItemCategories.php");

session_start();
$id = $_SESSION['idUser'];
$username = $_SESSION['namaUser'];
if ($id == "") {
    header("location: index.php");
}

$key = "";
$ctgryKey = 0;

if (isset($_GET['key'])) {
    $search = "%" . $_GET['key'] . "%";
    $key = $_GET['key'];
} else {
    $search = "%";
    $key = "";
}

if (isset($_GET['category'])) {
    $searchCategory = $_GET['category'];
    $ctgryKey = $_GET['category'];
} else {
    $searchCategory = 0;
    $ctgryKey = 0;
}

$lostItem = new ItemLost();
$perPageNum = 10;
$totalData = $lostItem->QueryNoLimit($search, 0, $searchCategory)->num_rows;
$jumlahPage = ceil($totalData / $perPageNum);

//SELECT WITH LIMIT
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 1;
}

if (!is_numeric($p))
    $p = 1;

$startPage = ($p - 1) * $perPageNum;
// $result = $lostItem->QueryLimit($search, 0, $searchCategory, $startPage, $perPageNum);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // session_start();
    // $id = $_SESSION['idUser'];
    // if ($id == "") {
    //     header("location: index.php");
    // }
    
    ?>
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Home</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <link href="css\carousel.css" rel="stylesheet">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
        }

        .layer {
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>
    <?php
    // $key = "";
    // $ctgryKey = 0;
    
    // if (isset($_GET['key'])) {
    //     $search = "%" . $_GET['key'] . "%";
    //     $key = $_GET['key'];
    // } else {
    //     $search = "%";
    //     $key = "";
    // }
    
    // if (isset($_GET['category'])) {
    //     $searchCategory = $_GET['category'];
    //     $ctgryKey = $_GET['category'];
    // } else {
    //     $searchCategory = 0;
    //     $ctgryKey = 0;
    // }
    ?>
    <nav class="navbar navbar-expand-lg bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('home_page')}}">FindUtopia</a>
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
                        <a class="nav-link active" aria-current="page" href="userslostitemlist.php?user=<?php echo $id ?>">Find My Lost Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="javascript:void(0)" id="logout"
                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Log Out</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search Lost Item" aria-label="Search"
                        name="key" value="<?php echo $key ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <br>
    <div class='container-fluid' id="mainContent">

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

        <h1 class="h1 mb-3 text-center">FindUtopia</h1>
        <br>
        <h6>Welcome , <?php echo $username; ?></h6>
        <br>
        <!-- carousel -->
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $priorityItem = new ItemLost();
                $totalDataPriority = $priorityItem->queryFeatured()->num_rows;
                for ($x = 0; $x < $totalDataPriority; $x++) {
                    if ($x == 0) {
                        echo "<button type='button' data-bs-target='#myCarousel' data-bs-slide-to='$x' class='active'
                        aria-current='true' aria-label='Slide " . ($x + 1) . "'></button>";
                    } else {
                        echo "<button type='button' data-bs-target='#myCarousel' data-bs-slide-to='$x' aria-label='Slide " . ($x + 1) . "'></button>";
                    }
                }

                ?>
            </div>
            <div class="carousel-inner">
                <?php
                $result = $priorityItem->queryFeatured();
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($count == 0) {
                        echo "<div style='background:black;' class='carousel-item active'>";
                    } else {
                        echo "<div style='background:black;' class='carousel-item'>";
                    }

                    echo "<img style='object-fit: cover;opacity: 0.4;' src='lost_images/" . $row['id'] . "." . $row['ext'] . "' alt='" . $row['name'] . "' class='bd-placeholder-img' width='100%'";
                    echo "height='100%'>";
                    echo "<div class='container-fluid' width='100%' height='100%'>";
                    echo "<div class='carousel-caption text-start'>";
                    echo "<h1 style='text-shadow: 5px 5px 10px rgba(0, 0, 0, 1)'>" . $row['name'] . "</h1>";
                    echo "<h3 style='text-shadow: 5px 5px 10px rgba(0, 0, 0, 1)'>" . $row['location'] . "</h3>";
                    echo "<h4 style='text-shadow: 5px 5px 10px rgba(0, 0, 0, 1)'>" . $row['noHp'] . "</h4>";
                    echo "<p><a class='btn btn-lg btn-primary' href='lihatitemlost.php?id=" . $row['id'] . "'>Check Item</a></p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    $count += 1;
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- end of carousel -->
        <div class="dropdown text-end mb-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?php
                $categories = new ItemCategories();
                if ($ctgryKey == 0) {
                    echo "Category Filter";
                } else {
                    $result = $categories->queryName($ctgryKey);
                    if ($row = $result->fetch_assoc()) {
                        echo $row['name'];
                    }
                }
                ?>
            </button>
            <ul class="dropdown-menu">
                <?php
                echo "<li><a class='dropdown-item' href='home.php?p=$p&key=$key&category=0'>No Filter</a></li>";

                $resultCategories = $categories->query();
                while ($row = $resultCategories->fetch_assoc()) {
                    echo "<li><a class='dropdown-item' href='home.php?p=$p&key=$key&category=" . $row['id'] . "'>" . $row['name'] . "</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class='accordion' id='accordionParent'>
            <?php
            // $lostItem = new ItemLost();
            // $perPageNum = 10;
            // $totalData = $lostItem->QueryNoLimit($search, 0, $searchCategory)->num_rows;
            // $jumlahPage = ceil($totalData / $perPageNum);
            
            // //SELECT WITH LIMIT
            // if (isset($_GET['p'])) {
            //     $p = $_GET['p'];
            // } else {
            //     $p = 1;
            // }
            
            // if (!is_numeric($p))
            //     $p = 1;
            
            // $startPage = ($p - 1) * $perPageNum;
            $result = $lostItem->QueryLimit($search, 0, $searchCategory, $startPage, $perPageNum);

            while ($row = $result->fetch_assoc()) {
                $imageId = $row['id'];
                $imageExt = $row['ext'];
                if ($row['ext'] == "") {
                    $imageId = "noImage";
                    $imageExt = "png";
                }
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
                echo "<h5 class='card-title'>" . $row['itemName'] . "</h5>";
                echo "<p class='card-text'>" . $row['description'] . "</p>";
                echo "<ul class='list-group list-group-flush'>";
                echo "<li class='list-group-item'>Date: " . date("d F Y", strtotime($row['date'])) . "</li>";
                echo "<li class='list-group-item'>Contact: " . $row['noHp'] . "</li>";
                echo "<li class='list-group-item'>Category: " . $row['category'] . "</li>";
                echo "<li class='list-group-item'>Location: " . $row['location'] . "</li>";
                echo "</ul>";

                echo "</div>";
                echo "</div>";
                echo "<div class='card-body'>";
                echo "<a class='w-100 btn btn-lg btn-primary' href='lihatitemlost.php?id=" . $row['id'] . "'>Detail</a>";
                echo "</div>";
                echo "</div>";

                echo "</div>";

                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>

        <br>
        <nav aria-label="...">
            <ul class="pagination">
                <?php
                if ($p != 1) {
                    $prev = $p - 1;
                    echo "<li class='page-item'><a class='page-link' href='home.php?p=$prev&key=$key&category=$ctgryKey'>Previous</a></li>";
                }
                if ($p == 1) {
                    echo "<li class='page-item disabled'><a class='page-link'>Previous</a></li>";
                }

                for ($i = 1; $i <= $jumlahPage; $i++) {
                    if ($i == $p) {
                        echo "<li class='page-item active' aria-current='page'><a class='page-link' href='home.php?p=$i&key=$key&category=$ctgryKey'>$i</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='home.php?p=$i&key=$key&category=$ctgryKey'>$i</a></li>";
                    }
                }

                if ($p != $jumlahPage && $totalData !=0) {
                    $next = $p + 1;
                    echo "<li class='page-item'><a class='page-link' href='home.php?p=$next&key=$key&category=$ctgryKey'>Next</a></li>";
                }
                if ($p == $jumlahPage || $totalData ==0) {
                    echo "<li class='page-item disabled'><a class='page-link'>Next</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>




    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>

</body>

</html>