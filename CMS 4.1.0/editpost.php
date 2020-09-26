<?php include 'header/header.php';
include 'database/function.inc.php';
session_login();
?>

<!-------------------------header---------------------------------->
<header class="bg-dark basic-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="fa fa-edit mr-2"></i>Edit Post</h1>
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
            if (isset($_GET['edit'])) {
                $edit = $_GET['edit'];
                if ($edit == "empty") {
                    echo '<div class="display-error">You have not filled title!</div>';
                } elseif ($edit == "characterError") {
                    echo '<div class="display-error">You title have unnecessary character in title!</div>';
                } elseif ($edit == "SQLError") {
                    echo '<div class="display-error">SQL Error!</div>';
                } elseif ($edit == "success") {
                    echo '<div class="display-error">You have been Edited successfully!</div>';
                } else if ($edit == "SQLerror") {
                    echo '<div class="display-error">There is someting error in database!</div>';
                } else if ($edit == "bigger_size") {
                    echo '<div class="display-error">The image size is too big!. Try smaller size.</div>';
                } else if ($edit == "error") {
                    echo '<div class="display-error">There is an error while uploading the image!.</div>';
                } else if ($edit == "not_type") {
                    echo '<div class="display-error">The image you uploaded is not the matchable type!. Try jpg, jpeg ,png , pdf.</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <?php
            include_once 'database/database_conn.inc.php';

            $newidsearch = mysqli_real_escape_string($conn, $_GET['id']);

            $sql = "select * from addnewpost where id = ?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There is some error!";
            } else {
                mysqli_stmt_bind_param($stmt, "i", $newidsearch);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $image = $row["image"];
                    $post = $row["post"];
                    $id = $row["id"];


            ?>
            <form action="database/editpost.inc.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="card bg-secondary card-container">
                    <div class="card-body text-white bg-dark">
                        <label for="ptitle" class="card-text mb-0">Post Title: </label>
                        <input type="text" name="posttitle" placeholder="Type title here" id="ptitle" class="mb-2"
                            value="<?php echo $row['post_title'] ?>">


                        <!-------------- select for title name from categories------------------>
                        <span>Choose Categories</span>
                        <?php
                                echo '<div class="category-edit mb-1">Extisting Category: <span>' . $row["category"] . '</span></div>';
                                ?>
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
                        <?php
                                echo '<div class="image-edit mb-2">Extisting Image: <span><img src="images/' . $image . '" width="150px" height="60px"></span></div>';
                                ?>
                        <input type="file" name="file" id="imageselect" class="image-upload mb-2">
                        <label for="postmessage" class="mb-0">Post</label>
                        <textarea name="message" id="postmessage" class="text-title"><?php echo $post; ?></textarea>

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

            <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<?php include 'footer/footer.php'; ?>