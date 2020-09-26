<?php include 'header/header.php';
include 'database/function.inc.php';
session_login(); ?>

<!-------------------------header---------------------------------->
<header class="bg-dark basic-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="fa fa-edit mr-2"></i>Add New Admin</h1>
            </div>
        </div>
    </div>
</header>

<!-------------------admin------------------------------------>
<!--py is represented to padding in y-axis, it seems to be padding in top and buttom-------------->
<section class="container py-3">
    <div class="row">
        <!-----offset means the leaving of column according to the number mentioned------>
        <div class="offset-lg-1 col-lg-10">
            <!----------------------error message for submit of admins--------------------------------->
            <?php
            if (isset($_GET['submit'])) {
                $submit = $_GET['submit'];
                if ($submit == "empty") {
                    echo '<div class="display-error">You have not filled title!</div>';
                } elseif ($submit == "nomatch") {
                    echo '<div class="display-error">Password and confirm Password should be same!</div>';
                } elseif ($submit == "invalidusername") {
                    echo '<div class="display-error">Username should contain number and letter!</div>';
                } elseif ($submit == "characterError") {
                    echo '<div class="display-error">You title have unnecessary character in title!</div>';
                } elseif ($submit == "sqlerror") {
                    echo '<div class="display-error">SQL Error!</div>';
                } elseif ($submit == "usertaken") {
                    echo '<div class="display-error">The entired username is already existed!</div>';
                } elseif ($submit == "success") {
                    echo '<div class="display-error">You have been submitted successfully!</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <!----------------------error message for submit of admins--------------------------------->

            <!----------------------error message for delete of categories--------------------------------->
            <?php
            if (isset($_GET['delete'])) {
                $delete = $_GET['delete'];
                if ($delete == "sqlerror") {
                    echo '<div class="display-error">SQL Error!</div>';
                } elseif ($delete == "deleted") {
                    echo '<div class="display-error">You have been deleted category successfully!</div>';
                } else {
                    echo '<div class="display-error">There is someting error!</div>';
                }
            }
            ?>
            <!----------------------error message for delete of categories--------------------------------->
            <form action="database/admins.inc.php" method="POST">
                <div class="card bg-secondary card-container">
                    <div class="card-header">
                        <h1>Add New Admin</h1>
                    </div>
                    <div class="card-body text-white bg-dark admin-input">
                        <!-------------------- username input field  ---------------------------->
                        <label for="Username" class="card-text">Username </label>
                        <input type="text" name="username" placeholder="Username" id="Username" class="mb-2" required>
                        <!-------------------- name input field ---------------------------->
                        <label for="Name" class="card-text">Name </label>
                        <input type="text" name="name" placeholder="Name" id="Name" class="mb-2">
                        <!-------------------- password input field ---------------------------->
                        <label for="Password" class="card-text">Password </label>
                        <input type="password" name="password" placeholder="Password" id="Password" class="mb-2"
                            required>
                        <!-------------------- confirm password input field ---------------------------->
                        <label for="ConfirmPassword" class="card-text">Confirm Password </label>
                        <input type="password" name="confirmpassword" placeholder="Confirm Password"
                            id="ConfirmPassword" class="mb-2" required>

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
            <!-------------------------table for showing the data of all categories-------------------------------->
            <div class="approved-comments mt-3">
                <h1>Existing Categories</h1>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Username</th>
                            <th scope="col">Admin Name</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'database/database_conn.inc.php';
                        $sql = "SELECT * FROM admins";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo '<div class="display-error mb-2">SQL Error!</div>';
                            exit();
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $resultcheck = mysqli_num_rows($result);
                            $increment = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                <td>' . $increment . '</td>
                                <td>' . $row['datetime'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['addedby'] . '</td>
                                <td><a href="database/deleteadmins.inc.php?id=' . $row['id'] . '" class="btn btn-danger mb-2">Delete</a>
                                </td>
                            </tr>';
                                $increment++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-------------------------table for showing the data of all categories-------------------------------->
        </div>
    </div>
</section>
<?php include 'footer/footer.php'; ?>