<?php
session_start();
include 'database_conn.inc.php';
include 'datetime.inc.php';
include 'function.inc.php';
if (isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    if (empty($username) || empty($password)) {
        Redirect("login.php?login=empty");
        exit();
    } else {
        $sql = "select * from admins where username = ? limit 1;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            Redirect("login.php?login=error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultcheck = mysqli_num_rows($result);
            if ($resultcheck < 1) {
                Redirect("login.php?login=notmatching");
                exit();
            } else if ($resultcheck == 1) {
                if ($row = mysqli_fetch_assoc($result)) {
                    //de-hashing the password
                    $dehashedpw = password_verify($password, $row["password"]);
                    if ($dehashedpw == false) {
                        Redirect("login.php?login=unverified");
                        exit();
                    } else if ($dehashedpw == true) {
                        //login the user here
                        $_SESSION["u_id"] = $row["id"];
                        $_SESSION["u_datetime"] = $row["datetime"];
                        $_SESSION["u_username"] = $row["username"];
                        $_SESSION["u_name"] = $row["name"];
                        $_SESSION["u_addedby"] = $row["addedby"];
                        Redirect("posts.php?login=success");
                        exit();
                    }
                }
            } else {
                Redirect("login.php?login=no");
                exit();
            }
        }
    }
}