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
    <title>Contact Us</title>

    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style type="text/css">

        

        #whatsappBtn:hover {
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
                        <a class="nav-link active" aria-current="page" href="usersfounditemlist.php?user=<?php echo $id ?>">My Found
                            Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="userslostitemlist.php?user=<?php echo $id ?>">Find My
                            Lost Item</a>
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

        <h1 class="h1 mb-3 text-center">Contact Us </h1>
        <div class="container col-xxl-8 px-4 py-5">
            <div>
                <h6>Welcome to Our "Contact Us" Page</h6>
                <p>
                    Our "Contact Us" page serves as a direct avenue for addressing concerns or queries regarding the retrieval of found items. If you've encountered challenges in obtaining an item that matches your lost possession or faced difficulties with the delivery process, our dedicated team is here to assist you promptly.
                </p>
            </div>

            <div>
                <h6>How to Reach Us:</h6>

                <p>
                    - Direct Email: Reach out to us directly at <b>wahyusriadijaya@gmail.com</b> with your concerns, including any relevant details to facilitate a swift resolution.
                </p>

                <div>
                    <p style='display:inline-block;'>
                    - Phone Support: For urgent matters or immediate assistance, you can contact our support team at
                    </p>
                    
                    <p id='whatsappBtn' style='background-color: #25D366;display:inline-block;border-radius:20px;padding:0px;margin-left:20px;'>
                        <a class='btn btn-lg' style='font-size: 15px;' href='https://wa.me/6282144714882?text=Halo%20Saya%20Pemilik Dari%20$namaBarang'>+6282144714882</a>
                    </p>
                </div>




            </div>
        </div>
    </div>
    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js\jquery-3.7.1.min.js"></script>
    <script src="js\logout.js"></script>
</body>

</html>