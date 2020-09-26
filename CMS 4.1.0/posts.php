<?php include 'header/header.php';
include 'database/function.inc.php';
?>

<?php session_login(); ?>

<!-------------------------header---------------------------------->
<header class="bg-dark basic-container mb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa fa-blogs mr-2"></i>Blogs Post</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addnewpost.php">
                    <button class="btn btn-primary btn-block ">
                        <i class="fa fa-edit mr-2"></i>Add New Post
                    </button>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="categories.php">
                    <button class="btn btn-info btn-block">
                        <i class="fa fa-folder-o mr-2"></i>Add New Category
                    </button>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="admin.php">
                    <button class="btn btn-warning btn-block">
                        <i class="fa fa-user-plus mr-2"></i>Add New Admin
                    </button>
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="comment.php">
                    <button class="btn btn-success btn-block">
                        <i class="fa fa-check mr-2"></i>Approve Comments
                    </button>
                </a>
            </div>

        </div>
    </div>
</header>
<!-------------------------header---------------------------------->


<section class="container mb-3 py-2">
    <!------------- error message for edit code ------------------------>
    <?php
    if (isset($_GET['edit'])) {
        $edit = $_GET['edit'];
        if ($edit == "empty") {
            echo '<div class="display-error">You have not filled title!</div>';
        } elseif ($edit == "characterError") {
            echo '<div class="display-error">You have unnecessary character in title!</div>';
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

    <!------------- error message for delete code ------------------------>
    <?php
    if (isset($_GET["delete"])) {
        $delete = $_GET["delete"];
        if ($delete == "sqlerror") {
            echo '<div class="display-error">There is someting error in database!</div>';
        } else if ($delete == "successfull") {
            echo '<div class="display-error">Your data have been successfully deleted!</div>';
        } else {
            echo '<div class="display-error">There is someting error!</div>';
        }
    }
    ?>

    <div class="container row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr class="tr-color">
                        <th>#</th>
                        <th class="title-over">Title</th>
                        <th>Categories</th>
                        <th>Date & Time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    <?php
                    include_once 'database/database_conn.inc.php';

                    $sql = "select * from addnewpost;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "You have a SQL Error!";
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $increment = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                            $post = $row["post_title"];
                            $categories = $row["category"];
                            $time = $row["datetime"];
                            $author = $row["author"];
                            $img = $row['image'];
                    ?>
                    <tr>
                        <td><?php echo $increment ?></td>
                        <td><?php echo $post ?></td>
                        <td><?php echo $categories ?></td>
                        <td><?php echo $time ?></td>
                        <td><?php echo $author ?></td>
                        <td>
                            <image src="images/<?php echo $img ?>" width="170px" height="50px">
                        </td>
                        <td><span class="approved-cmt"> <?php
                                                                ApprovedComments($id);
                                                                ?>
                            </span>
                            <span class="disapproved-cmt"> <?php
                                                                    DisApprovedComments($id);
                                                                    ?>
                            </span>
                        </td>
                        <td>
                            <a href="editpost.php?id=<?php echo $id ?>" target="_blank"
                                class="btn btn-warning mb-2">Edit</a>
                            <a href="deletepost.php?id=<?php echo $id ?>" class="btn btn-danger mb-2">Delete</a>
                        </td>
                        <td>
                            <a href="fullpost.php?id=<?php echo $id ?>" target="_blank" class="btn btn-primary">Live
                                Review</a>
                        </td>
                    </tr>
                    <?php $increment++;
                        }
                    } ?>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include 'footer/footer.php'; ?>