<?php

include 'database_conn.inc.php';
include 'datetime.inc.php';
session_start();

if (isset($_POST["submit"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    //self declare value
    $approvedby = $_SESSION["u_username"];
    $status = "OFF";

    $commentname = mysqli_real_escape_string($conn, $_POST["commentname"]);
    $commentemail = mysqli_real_escape_string($conn, $_POST["commentemail"]);
    $commenttext = mysqli_real_escape_string($conn, $_POST["commenttext"]);

    //empty check
    if (empty($commentname) || empty($commentemail) || empty($commenttext)) {
        header("Location: ../fullpost.php?id=$id.comment=empty");
        exit();
    } else {
        //preg_match check
        if (!preg_match("/^[A-Za-z. ]{3,}$/", $commentname) || !preg_match("/^[a-zA-z.-_%]+@[a-zA-z.-_%]+\.[a-zA-z.-_%]+$/", $commentemail)) {
            header("Location: ../fullpost.php?id=$id.comment=characterError");
            exit();
        } else {
            //email check
            if (!filter_var($commentemail, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../fullpost.php?id=$id.comment=emaileroor");
                exit();
            } else {
                //insert data
                $sql = "insert into comments(`datetime`, name, email, comment, approvedby, status, post_id) values(?,?,?,?,?,?,?);";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../fullpost.php?id=$id.comment=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssssi", $datetime, $commentname, $commentemail, $commenttext, $approvedby, $status, $id);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../fullpost.php?id=$id&comment=success");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../fullpost.phpid=.$id.");
    exit();
}