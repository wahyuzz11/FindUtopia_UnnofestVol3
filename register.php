<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="src_images/icon.ico">
    <title>Register</title>
    <link href="bootstrap-5.2.3-dist\css\bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <link href="css\signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <div class="form-signin w-100 m-auto">
    <img class="mb-4" src="src_images\logo_transparent.png" alt="128" width="" height="128">
    <h1 class="h3 mb-3 fw-normal">Please Register</h1>
        <?php
        require_once('class/users.php');
        if (isset($_POST['kirim'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repass = $_POST['repassword'];
            $name = $_POST['name'];

            $user = new users();

            $user->register($username, $name, $password, $repass);
        }
        // else {
        //     echo "Belum melakukan register";
        // }

        ?>
        <form method="POST">
          
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingUsername" name="username" required autofocus>
                <label for="floatingUsername">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingName" name="name" required>
                <label for="floatingName">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingRepassword" name="repassword" required>
                <label for="floatingRepassword">Confirm Password</label>
            </div>
            <!-- <label>Username : </label><input type="text" name="username" required autofocus><br>
            <label>Nama : </label><input type="text" name="name" required autofocus><br>
            <label>Password : </label><input type="password" name="password" required><br>
            <label>Re password : </label><input type="password" name="repassword" required><br> -->
            <input class="w-100 btn btn-lg btn-primary" type="submit" value="REGISTER DATA" name="kirim">
            <p class="mt-5 mb-3 text-muted">&copy; FindUtopia 2023</p>
        </form>
    </div>


    <script src="bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>

</body>

</html>