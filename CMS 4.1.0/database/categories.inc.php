<?php

include 'database_conn.inc.php';
include 'datetime.inc.php';
session_start();
if (isset($_POST["submit"])) {
    $categoriestitle = mysqli_real_escape_string($conn, $_POST["categoriestitle"]);
    $author = $_SESSION["u_username"];

    if (empty($categoriestitle)) {
        header("Location: ../categories.php?submit=empty");
        exit();
    } else {
        if (!preg_match("/^[a-zA-Z0-9_\-\.\/\&% ]{3,}$/", $categoriestitle)) {
            header("Location: ../categories.php?submit=characterError");
            exit();
        } else {
            $sql = "insert into categories(title,author,datetime) values(?,?,?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../categories.php?submit=SQLError");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "sss", $categoriestitle, $author, $datetime);
                mysqli_stmt_execute($stmt);
                header("Location: ../categories.php?submit=success");
                exit();
            }
        }
    }
}