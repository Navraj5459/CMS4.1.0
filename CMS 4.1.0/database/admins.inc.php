<?php
include 'database_conn.inc.php';
include 'datetime.inc.php';
session_start();

if (isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);
    $adddby = $_SESSION["u_username"];

    if (empty($username) || empty($password) || empty($confirmpassword)) {
        header("Location: ../admin.php?submit=empty");
        exit();
    } else {
        if ($password !== $confirmpassword) {
            header("Location: ../admin.php?submit=nomatch");
            exit();
        } else {
            if (!preg_match("/^[a-zA-Z][A-Za-z0-9_\-@]{3,16}$/", $username)) {
                header("Location: ../admin.php?submit=invalidusername");
                exit();
            } else {
                $sql = "select * from admins where username = ?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location ../admin.php?submit=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $resultcheck = mysqli_num_rows($result);
                    if ($resultcheck >= 1) {
                        header("Location: ../admin.php?submit=usertaken");
                        exit();
                    } else {
                        //hashing the password
                        $hashedpw = password_hash($password, PASSWORD_DEFAULT);
                        //insert data into admin table
                        $sql = "insert into admins(datetime, username, password, name, addedby) values(?, ?, ?, ?, ?);";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location ../admin.php?submit=sqlerror");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssss", $datetime, $username, $hashedpw, $name, $adddby);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../admin.php?submit=success");
                            exit();
                        }
                    }
                }
            }
        }
    }
} else {
    header("Location: ../admin.php");
    exit();
}