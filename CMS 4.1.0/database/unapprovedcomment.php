<?php
session_start();
include 'database_conn.inc.php';
if (isset($_GET["id"])) {
    $unapprovedby = $_SESSION["u_name"];
    $status = "OFF";
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "UPDATE comments SET `status` = ?, approvedby = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../comment.php?comment=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssi", $status, $unapprovedby, $id);
        mysqli_stmt_execute($stmt);
        header("Location: ../comment.php?comment=un-approved");
        exit();
    }
}