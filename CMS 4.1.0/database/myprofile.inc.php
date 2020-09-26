<?php

include 'database_conn.inc.php';
session_start();
include 'function.inc.php';

if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $headline = mysqli_real_escape_string($conn, $_POST["headline"]);
    $bio = mysqli_real_escape_string($conn, $_POST["bio"]);
    $file = $_FILES["file"];
    $id = $_SESSION["u_id"];
    $defaultname = $_SESSION["u_name"];

    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileTmpName = $_FILES["file"]["tmp_name"];
    $fileError = $_FILES["file"]["error"];
    $fileSize = $_FILES["file"]["size"];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('png', 'jpg', 'pdf', 'jpeg');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                $fileNewName = $fileName . "." . uniqid('', true) . "." . $fileActualExt;
                $fileDestination = "../images/" . $fileNewName;

                if (empty($headline) || empty($bio) || empty($file)) {
                    header("Location: ../myprofile.php?edit=empty");
                    exit();
                } else if (empty($name && !empty($headline) && !empty($bio) && !empty($file))) {
                    $sql = "UPDATE admins SET headline = ?, images = ?, bio = ?, `name` = ? WHERE id = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../myprofile.php?edit=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssi", $headline, $fileNewName, $bio, $defaultname, $id);
                    }
                } else {
                    $sql = "UPDATE admins SET headline = ?, images = ?, bio = ?, `name` = ? WHERE id = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../myprofile.php?edit=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssi", $headline, $fileNewName, $bio, $name, $id);
                    }
                }
                mysqli_stmt_execute($stmt);
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: ../myprofile.php?edit=success");
                exit();
            } else {
                header("Location: ../myprofile.php?edit=bigsize");
                exit();
            }
        } else {
            header("Location: ../myprofile.php?edit=error");
            exit();
        }
    } else {
        header("Location: ../myprofile.php?edit=not_type");
        exit();
    }
} else {
    header("Location: ../myprofile.php");
    exit();
}