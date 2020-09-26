<?php include 'header/header.php';
include 'database/function.inc.php';
session_login();
?>

<!-------------------------header---------------------------------->
<header class="bg-dark basic-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="fa fa-edit mr-2"></i>Add New Post</h1>
            </div>
        </div>
    </div>
</header>

<!-------------------Categories------------------------------------>
<!--py is represented to padding in y-axis, it seems to be padding in top and buttom-------------->
<section class="container py-3">
    <div class="row">
        <!-----offset means the leaving of column according to the number mentioned------>
        <div class="offset-lg-1 col-lg-10">
            <?php
            if (isset($_GET['submit'])) {
                $submit = $_GET['submit'];
                if ($submit == "empty") {
                    echo '<div class="display-error">You have not filled title!</div>';
                } elseif ($submit == "characterError") {
                    echo '<div class="display-error">You title have unnecessary character in title!</div>';
                } elseif ($submit == "SQLError") {
                    echo '<div class="display-error">SQL Error!</div>';
                } elseif ($submit == "success") {
                    echo '<div class="display-error">You have been submitted successfully!</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <form action="database/addnewpost.inc.php" method="POST" enctype="multipart/form-data">
                <div class="card bg-secondary card-container">
                    <div class="card-body text-white bg-dark">
                        <label for="ptitle" class="card-text mb-0">Post Title: </label>
                        <input type="text" name="posttitle" placeholder="Type title here" id="ptitle" class="mb-2">
                        <span>Choose Categories</span>

                        <!-------------- select for title name from categories------------------>
                        <select name="categorieschoose" id="categoriestitle" class="category-select mb-2">
                            <?php
                            include 'database/database_conn.inc.php';
                            $sql = "select * from categories;";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There is SQL error!";
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option>' . $row["title"] . '</option>';
                                }
                            }
                            ?>
                        </select>

                        <label for="imageselect" class="image-post mb-0">Select Image</label>
                        <input type="file" name="file" id="imageselect" class="image-upload mb-2">
                        <label for="postmessage" class="mb-0">Post</label>
                        <textarea name="message" id="postmessage" class="text-title"></textarea>

                        <!---------new row for back and submit----------->
                        <div class="row bg-dark">
                            <div class="col-lg-6 py-2 back-dashboard">
                                <a href="dahboard.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back To
                                    Dashboard</a>
                            </div>
                            <div class="col-lg-6 py-2 submit-button">
                                <button type="submit" name="submit" class="btn-primary"><i class="fa fa-check"></i>
                                    Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php include 'footer/footer.php'; ?>