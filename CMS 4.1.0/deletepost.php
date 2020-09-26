<?php
include_once 'database/database_conn.inc.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

//this is select statement for immage file 
$sql = "select * from addnewpost where id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: posts.php?delete=sqlerrorselect");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $sql = "delete from addnewpost where id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: posts.php?delete=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $imagelocation = "images/" . $row["image"];
            unlink($imagelocation);
            header("Location: posts.php?delete=successfull");
        }
    }
}