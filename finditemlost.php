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
    <title>Item Lost Match</title>

    <!-- <style type="text/css">
        body {
            /* background-color: #DFD7BF; */
        }

        /* sa */
        .card {
            border-radius: 30px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.25);
            width: 200px;
            height: 350px;
            margin: 10px;
            float: left;
            border-radius: 20px;
            background-color: #6495ED;
        }


        img {
            /*width: 200px;*/
            height: 200px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        p,
        #btnContainer {
            text-align: center;
            font-size: 15px;
            font-family: Arial;
        }

        .namaItem {
            font-weight: 600;

        }


        #container {
            /* position: relative; */
            display: flex;
            flex-wrap: wrap;
        }

        @media screen and (max-width: 865px) {
            #container {
                flex-direction: column;
            }

        }
    </style> -->

    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">


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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            List
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="userslostitemlist.php?user=<?php echo $id ?>">My
                                    Lost Item</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="listFound.php">List of Found Item</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container-fluid">
        <h1 class="h1 mb-3 text-center">Matching Items</h1>
        <br>
        <div class="accordion" id='accordionParent'>
            <?php
            require_once("class/itemLost.php");
            $idUser = $_GET['user'];
            $namaItem = $_GET['item'];
            $location = $_GET['location'];
            $category = $_GET['category'];
            $lost = $_GET['lost'];
            $itemLost = new ItemLost();
            $result = $itemLost->Matching($idUser, $namaItem, $category, $location);

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
                echo "<img src='found_images/" . $imageId . "." . $imageExt . "' class='card-img-top img-thumbnail'";
                echo "alt='Lost Image'>";
                echo "</div>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['itemName'] . "</h5>";
                echo "<p class='card-text'>" . $row['description'] . "</p>";
                echo "</div>";
                echo "<ul class='list-group list-group-flush'>";
                echo "<li class='list-group-item'>Date: " . date("d F Y", strtotime($row['date'])) . "</li>";
                echo "<li class='list-group-item'>Contact: " . $row['noHp'] . "</li>";
                echo "<li class='list-group-item'>Category: " . $row['category'] . "</li>";
                echo "<li class='list-group-item'>Location: " . $row['location'] . "</li>";
                echo "</ul>";
                echo "<a class='w-100 btn btn-lg btn-primary' href='lihatitemfounds.php?id=" . $row['id'] . "'>Detail</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <!-- <div id="container">
        <?php
        // require_once("class/itemLost.php");
        // $idUser = $_GET['user'];
        // $namaItem = $_GET['item'];
        // $location = $_GET['location'];
        // $category = $_GET['category'];
        // $lost = $_GET['lost'];
        // $itemLost = new ItemLost();
        // $result = $itemLost->Matching($idUser, $namaItem, $category, $location);
        
        // while ($row = $result->fetch_assoc()) {
        //     echo "<div class='card' id='c-" . $row['id'] . "'>";
        //     $id = $row['id'];
        //     echo "<img src= 'found_images/" . $row['id'] . "." . $row['ext'] . "' width='200px' alt='" . $row['name'] . "'>";
        //     echo "<p class='namaItem'>" . $row['name'] . "</p>";
        //     echo "<p class='tglItem'>" . date("d F Y", strtotime($row['date'])) . " </p>";
        //     echo "<p class='namaPenemu'" . $row['nama_penemu'] . "</p>";
        //     echo "<br>";
        //     echo "<div id='btnContainer'>";
        //     echo "<a href='lihatitemfounds.php?found=$id&lost=$lost'>";
        //     echo "<button class='btnDetail'>Hubungi Sang Penemu</button>";
        //     echo "</a>";
        //     echo "</div>";
        //     echo "</div>";
        // }
        ?>
    </div> -->

    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>

</body>

</html>