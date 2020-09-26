<?php
include 'database/database_conn.inc.php';
include 'database/function.inc.php';
?>

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
    <title>Blog Page</title>
</head>

<body>
    <div class="blue-line"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Navraj.com</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 search-btn" method="GET" action="blog.php">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search"
                        aria-label="Search">
                    <button type="submit" class="btn btn-outline-primary btn-primary my-2 my-sm-0"
                        name="submitsearch">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="blue-line"></div>
    <!------------------------------main body part--------------------------------------------->
    <section class="container mt-2 mb-2">
        <div class="row py-3">
            <div class="col-sm-8 cms-header">
                <h1 class="header1">The Complete Responsive CMS Blog</h1>
                <h2 class="header2">The Complete blog using PHP by Navraj</h2>

                <!-----------  Card body here showing the whole posts --------------->
                <?php
                include_once 'database/database_conn.inc.php';

                if (isset($_GET['submitsearch'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);

                    $sql = "select * from addnewpost where post_title like ? or category like ? or author like ? or post like ? or datetime like ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../blog.post?search=error");
                        exit();
                    } else {
                        $search_like = "%$search%";
                        mysqli_stmt_bind_param($stmt, "sssss", $search_like, $search_like, $search_like, $search_like, $search_like);
                        mysqli_stmt_execute($stmt);
                        //showing result
                        $result = mysqli_stmt_get_result($stmt);
                        $resultCheck = mysqli_num_rows($result);
                        echo '<div class="display-result">There are ' . $resultCheck . ' results</div>';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image = $row['image'];
                            $post_title = $row['post_title'];
                            $author =  $row['author'];
                            $date = $row['datetime'];
                            $post = $row['post'];
                            $id = $row["id"];
                            $category = $row["category"];
                ?>
                <div class="card mb-2">
                    <img src="images/<?php echo $image ?>" class="card-img-top img-fluid">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo  $post_title ?></h5>
                        <span class="dateandtime mb-2">Category:<a href="blog.php?categories=<?php echo $category; ?>">
                                <?php echo $category; ?></a>
                            Written
                            by:<?php echo  $author; ?> On
                            <?php echo  $date; ?> </span>
                        <small class="comment"><span>Comments: <?php ApprovedComments($id); ?></span></small>
                        <p class="card-text"><?php echo  $post; ?></p>
                        <a href="fullpost.php?id=<?php echo  $id; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php }
                    }
                } else if (isset($_GET["categories"])) {
                    include 'database/database_conn.inc.php';
                    $categories_title = mysqli_real_escape_string($conn, $_GET["categories"]);
                    $sql = "SELECT * FROM addnewpost WHERE category = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo 'There is SQL error!';
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $categories_title);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image = $row['image'];
                            $post_title = $row['post_title'];
                            $author =  $row['author'];
                            $date = $row['datetime'];
                            $post = $row['post'];
                            $id = $row["id"];
                            $category = $row["category"];

                        ?>
                <div class="card mb-2">
                    <img src="images/<?php echo $image ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo  $post_title ?></h5>
                        <span class="dateandtime mb-2">Category:<a href="blog.php?categories=<?php echo $category; ?>">
                                <?php echo $category; ?></a>
                            Written
                            by:<?php echo  $author; ?> On
                            <?php echo  $date; ?> </span>
                        <small class="comment"><span>Comments: <?php ApprovedComments($id); ?></span></small>
                        <p class="card-text"><?php echo  $post; ?></p>
                        <a href="fullpost.php?id=<?php echo  $id; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php
                        }
                    }
                } else { ?>

                <?php
                    /* Full post code after search query */ //the default result for search 

                    $sql = "select * from addnewpost;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There is an Error while loading!";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image = $row['image'];
                            $post_title = $row['post_title'];
                            $author =  $row['author'];
                            $date = $row['datetime'];
                            $post = $row['post'];
                            $id = $row["id"];
                            $category = $row["category"];
                    ?>
                <div class="card mb-2">
                    <img src="images/<?php echo $image ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo  $post_title ?></h5>
                        <span class="dateandtime mb-2">Category:<a href="blog.php?categories=<?php echo $category; ?>">
                                <?php echo $category; ?></a>
                            Written
                            by:<?php echo  $author; ?> On
                            <?php echo  $date; ?> </span>
                        <small class="comment"><span>Comments: <?php ApprovedComments($id); ?></span></small>
                        <p class="card-text"><?php echo  $post; ?></p>
                        <a href="fullpost.php?id=<?php echo  $id; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php }
                    }
                } ?>
            </div>
            <!-----------------------------left side area of blog post---------------------------------------------->
            <div class="col-sm-4 blog-container">
                <div class="card card-advertise">
                    <img src="img/ISMT-College-Vacancy.jpg" class="card-img-top img-fluid" alt="Advertise">
                    <div class="card-body">
                        <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into electronic typesetting, remaining
                            essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                            containing Lorem Ipsum passages, and more recently with desktop publishing software like
                            Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
                <!---------------------------------signup form-------------------------------------------------->
                <div class="card card-wrapper mb-3">
                    <div class="card-header">
                        <h1>Sign Up!</h1>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success mb-3">Join the Form</button>
                        <button type="button" class="btn btn-danger mb-3">Join the Form</button>
                        <div class="subscribe mb-3">
                            <input type="text" name="subscribe" placeholder="Enter Your email">
                            <button type="button" class="btn btn-primary">Subscribe Now</button>
                        </div>
                    </div>
                </div>
                <!---------------------------------signup form-------------------------------------------------->
                <!---------------------------------categories list-------------------------------------------------->
                <div class="card card-wrapper">
                    <div class="card-header">
                        <h1>Categories</h1>
                    </div>
                    <div class="card-body card-categories">
                        <?php
                        include 'database/database_conn.inc.php';
                        $sql = "SELECT * FROM categories;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo 'There is an SQL error!';
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                <ul class="categories-list">
                            <li><a href="blog.php?categories=' . $row["title"] . '">' . $row["title"] . '</a></li>
                        </ul>
                                ';
                            }
                        }
                        ?>
                    </div>
                </div>
                <!---------------------------------categories list-------------------------------------------------->

                <!---------------------------------list of latest new-------------------------------------------------->
                <div class="card latest-news mt-3">
                    <div class="card-header">
                        <h1>Recent Post</h1>
                    </div>
                    <?php
                    include 'database/database_conn.inc.php';
                    $sql = "SELECT * FROM addnewpost ORDER BY id DESC LIMIT 0,5;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo 'There is SQL error';
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                        
                    <div class="media media-container">
                        <a href="fullpost.php?id=' . $row["id"] . '"><img src="images/' . $row["image"] . '" class="mr-3" alt="..."></a>
                        <div class="media-body">
                            <h5 class="mt-0">' . $row["post_title"] . '</h5>
                            ' . $row["datetime"] . '
                        </div>
                    </div>
                
                        ';
                        }
                    }
                    ?>
                </div>

                <!---------------------------------list of latest new-------------------------------------------------->

            </div>
            <!-----------------------------left side area of blog post---------------------------------------------->
        </div>
    </section>
    <!------------------------------main body part--------------------------------------------->


    <!-- Footer -->
    <footer class="page-footer font-small lighten-3 bg-dark pt-4">
        <div class="footer-container">
            <!-- Footer Links -->
            <div class="container text-center text-md-left">

                <!-- Grid row -->
                <div class="row">

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 mr-auto my-md-4 my-0 mt-4 mb-1">

                        <!-- Content -->
                        <h5 class="font-weight-bold text-uppercase mb-4">Footer Content</h5>
                        <p>Here you can use rows and columns to organize your footer content.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit amet numquam iure provident
                            voluptate
                            esse
                            quasi, veritatis totam voluptas nostrum.</p>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 mx-auto my-md-4 my-0 mt-4 mb-1">

                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mb-4">About</h5>

                        <ul class="list-unstyled">
                            <li>
                                <p>
                                    <a href="#">My profile</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="#">Dashboard</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="#">Post</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="categories.php">Categories</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="#">Manage Admin</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="#">Comments</a>
                                </p>
                            </li>
                            <li>
                                <p>
                                    <a href="#">Live Blogs</a>
                                </p>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 mx-auto my-md-4 my-0 mt-4 mb-1">

                        <!-- Contact details -->
                        <h5 class="font-weight-bold text-uppercase mb-4">Address</h5>

                        <ul class="list-unstyled">
                            <li>
                                <p>
                                    <i class="fa fa-home mr-2"></i> Kapilvastu, Banganga-11, Nepal
                                </p>
                            </li>
                            <li>
                                <p class="gmail">
                                    <i class="fa fa-envelope mr-2"></i>www.navarajbhattarai11@gmail.com
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-phone mr-2"></i>+977-9800784375
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-print mr-2"></i>+977-9863831841
                                </p>
                            </li>
                        </ul>

                    </div>
                    <!-- Grid column -->

                    <hr class="clearfix w-100 d-md-none">

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 text-center mx-auto my-4 social-media">

                        <!-- Social buttons -->
                        <h5 class="font-weight-bold text-uppercase mb-4">Follow Us</h5>

                        <!-- Facebook -->
                        <a type="button" class="btn-floating btn-fb">
                            <i class="fa fa-facebook-f"></i>
                        </a>
                        <!-- Twitter -->
                        <a type="button" class="btn-floating btn-tw">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <!-- Instagram-->
                        <a type="button" class="btn-floating btn-insta">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                        <!-- Youtube-->
                        <a type="button" class="btn-floating btn-youtube">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        </a>


                    </div>
                    <!-- Grid column -->

                </div>
                <!-- Grid row -->

            </div>
            <!-- Footer Links -->

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">&copy; 2020 Copyright:
                <a href="https://mdbootstrap.com/"> Navraj.com</a>
            </div>
            <!-- Copyright -->
        </div>
    </footer>
    <div class="blue-line"></div>
    <!-- Footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>