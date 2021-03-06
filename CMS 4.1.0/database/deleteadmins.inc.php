<?php

include 'database_conn.inc.php';
if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "delete from admins where id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../admin.php?delete=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        header("Location: ../admin.php?delete=deleted");
        exit();
    }
}