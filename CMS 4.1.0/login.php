<?php
include 'database/database_conn.inc.php';
include 'database/datetime.inc.php';
include 'database/function.inc.php';
session_start();
if (isset($_SESSION["u_id"])) {
    header("Location: dashboard.php");
}
?>

<!--------------------------menu  and navigation part------------------------------>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>CMS</title>
</head>

<body>
    <div class="blue-line"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Navraj.com</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="blue-line"></div>

    <!--------------------------menu  and navigation part------------------------------>

    <!-------------------------header---------------------------------->
    <header class="bg-dark basic-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1><i class="fa fa-edit mr-2"></i>Admin Login</h1>
                </div>
            </div>
        </div>
    </header>

    <!-------------------user login------------------------------------>
    <!--py is represented to padding in y-axis, it seems to be padding in top and buttom-------------->
    <section class="container py-3">
        <div class="login-container">
            <?php
            if (isset($_GET["login"])) {
                $login = $_GET["login"];
                if ($login == "empty") {
                    echo '<div class="display-error">You have not filled title!</div>';
                } else if ($login == "error") {
                    echo '<div class="display-error">SQL Error!</div>';
                } else if ($login == "notmatching") {
                    echo '<div class="display-error">There is no existing username</div>';
                } else if ($login == "unverified") {
                    echo '<div class="display-error">Unverified Username and Password</div>';
                } else if ($login == "success") {
                    echo '<div class="display-error">You are logged in! Welcome ' . $_SESSION["u_username"] . '</div>';
                } else if ($login == "required") {
                    echo '<div class="display-error">Login Required!</div>';
                }
            }
            ?>
            <form action="database/login.inc.php" method="POST">
                <div class="card bg-secondary card-container">
                    <div class="card-header">
                        <h1>Add New Admin</h1>
                    </div>
                    <div class="card-body text-white bg-dark admin-input">
                        <!-------------------- username input field  ---------------------------->
                        <label for="Username" class="card-text">Username </label>
                        <input type="text" name="username" placeholder="Username" id="Username" class="mb-2">

                        <!-------------------- password input field ---------------------------->
                        <label for="Password" class="card-text">Password </label>
                        <input type="password" name="password" placeholder="Password" id="Password" class="mb-2">

                        <!---------new row for back and submit----------->
                        <div class="bg-dark">
                            <div class="py-2 login-button">
                                <button type="submit" name="submit" class="btn-primary">
                                    Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include 'footer/footer.php'; ?>