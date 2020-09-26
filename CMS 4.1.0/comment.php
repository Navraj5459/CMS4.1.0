<?php include 'header/header.php';
include 'database/function.inc.php';
?>

<?php session_login(); ?>
<!-------------------------header---------------------------------->
<header class="bg-dark comment-container mb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <!-- <div class="comment-icons"> -->
                    <i class="fa fa-comments" aria-hidden="true"></i>Manage Comments
                    <!-- </div> -->
                </h1>
            </div>
        </div>
    </div>
</header>
<!-------------------------header---------------------------------->

<!------------- table code for showing the comments in table ------------------------>
<section class="container mb-3 py-2">
    <div class="container row">
        <div class="col-lg-12">
            <div class="approved-comments">
                <h1>Un-Approved Comments</h1>
            </div>
            <!------------- error message for delete and approves and un-approved comments code ------------------------>
            <?php
            if (isset($_GET["comment"])) {
                $comment = $_GET["comment"];
                if ($comment == "sqlerror") {
                    echo '<div class="display-error">There is someting error in database!</div>';
                } else if ($comment == "deleted") {
                    echo '<div class="display-error">Your comment have been successfully deleted!</div>';
                } else if ($comment == "approved") {
                    echo '<div class="display-error">Your comment have been successfully approved!</div>';
                } else if ($comment == "un-approved") {
                    echo '<div class="display-error">Your comment have been successfully Un-Approved!</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <!------------- error message for delete code ------------------------>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Approve</th>
                            <th scope="col">Action</th>
                            <th scope="col">Detais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'database/database_conn.inc.php';
                        $status = "OFF";
                        $sql = "SELECT * FROM comments WHERE `status` = ?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo '<div class="display-error mb-2">SQL Error!</div>';
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $status);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $resultcheck = mysqli_num_rows($result);
                            $increment = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td width="35px">' . $increment . '</td>
                                <td width="140px">' . $row['name'] . '</td>
                                <td width="120px">' . $row['datetime'] . '</td>
                                <td width="420px">' . $row['comment'] . '</td>
                                <td width="110px"><a href="database/approvedcomment.php?id=' . $row['id'] . '" class="btn btn-success mb-2">Approve</a></td>
                                <td width="95px"><a href="database/deletecomment.php?id=' . $row['id'] . '" class="btn btn-danger mb-2">Delete</a>
                                </td>
                                <td width="135px"><a href="fullpost.php?id=' . $row["post_id"] . '" target="_blank" class="btn btn-primary">Live Review</a></td>
                            </tr>';
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="approved-comments">
                <h1>Approved Comments</h1>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Approve</th>
                            <th scope="col">Action</th>
                            <th scope="col">Detais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'database/database_conn.inc.php';
                        $status = "ON";
                        $sql = "SELECT * FROM comments WHERE `status` = ?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo '<div class="display-error mb-2">SQL Error!</div>';
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $status);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $resultcheck = mysqli_num_rows($result);
                            $increment = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td width="20px">' . $increment . '</td>
                                <td width="140px">' . $row['name'] . '</td>
                                <td width="130px">' . $row['datetime'] . '</td>
                                <td width="415px">' . $row['comment'] . '</td>
                                <td width="150px"><a href="database/unapprovedcomment.php?id=' . $row['id'] . '" class="btn btn-success mb-2">Un-Approve</a></td>
                                <td width="95px"><a href="database/deletecomment.php?id=' . $row['id'] . '" class="btn btn-danger mb-2">Delete</a>
                                </td>
                                <td width="135px"><a href="fullpost.php?id=' . $row["post_id"] . '" target="_blank" class="btn btn-primary">Live Review</a></td>
                            </tr>';
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!------------- table code for showing the comments in table ------------------------>

<?php include 'footer/footer.php'; ?>