<?php include 'header/header.php';
include 'database/function.inc.php';
session_login(); ?>

<!-------------------------header---------------------------------->
<header class="bg-dark basic-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="fa fa-user mr-2"></i>@<?php echo $_SESSION["u_username"]; ?></h1>
            </div>
        </div>
    </div>
</header>

<!-------------------admin------------------------------------>
<!--py is represented to padding in y-axis, it seems to be padding in top and buttom-------------->
<section class="container py-3">
    <div class="row profile-admin">
        <div class="col-lg-3">
            <?php
            include 'database/database_conn.inc.php';
            $id = $_SESSION["u_id"];
            $sql = "SELECT * FROM admins WHERE id = ?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo 'There is SQL error!';
            } else {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $name = $row["name"];
                    $image = $row['images'];
                    echo '
                    <div class="card profile-card">
                <div class="card-header">
                    <h1>' . $name . '</h1>
        </div>
        <img src="images/' . $image . '" class="card-img-top" alt="...">
        <div class="card-body">
            <p class="card-text">' . $row['bio'] . '</p>
        </div>
    </div>
    ';
                }
            }
            ?>

        </div>
        <!-----offset means the leaving of column according to the number mentioned------>
        <div class="col-lg-9">
            <!----------------------error message for edit of admins--------------------------------->
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
                    echo '<div class="display-error">You have been submitted successfully!</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <!----------------------error message for edit of admins--------------------------------->
            <form action="database/myprofile.inc.php" method="POST" enctype="multipart/form-data">
                <div class="card bg-secondary card-container">
                    <div class="card-header">
                        <h1>Edit Profile</h1>
                    </div>
                    <div class="card-body text-white bg-dark admin-input">
                        <!-------------------- name input field  ---------------------------->
                        <label for="Name" class="card-text">Name </label>
                        <input type="text" name="name" placeholder="Name" id="Name" class="mb-2">
                        <!-------------------- headline input field ---------------------------->
                        <label for="Headline" class="card-text">Headline </label>
                        <input type="text" name="headline" placeholder="Headline" id="Headline" class="mb-2">
                        <!-------------------- bio input field ---------------------------->
                        <label for="Bio" class="card-text">Bio</label>
                        <textarea name="bio" id="Bio" class="text-title"></textarea>
                        <!-------------------- photo input field ---------------------------->
                        <label for="imageselect" class="image-post mt-2">Select Image</label>
                        <input type="file" name="file" id="imageselect" class="image-upload mb-2">

                        <!---------new row for back and submit----------->
                        <div class="row bg-dark">
                            <div class="col-lg-6 py-2 back-dashboard">
                                <a href="dahboard.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                                    Back
                                    To
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