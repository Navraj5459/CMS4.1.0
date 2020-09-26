<?php

include 'database_conn.inc.php';
include 'datetime.inc.php';
session_start();

if (isset($_POST["submit"])) {
    $posttitle = mysqli_real_escape_string($conn, $_POST["posttitle"]);
    $categorieschoose = mysqli_real_escape_string($conn, $_POST["categorieschoose"]);
    $file = $_FILES["file"];
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
    $author = $_SESSION["u_username"];


    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileTmp = $_FILES["file"]["tmp_name"];
    $fileError = $_FILES["file"]["error"];
    $fileSize = $_FILES["file"]["size"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $Allowed = array('jpg', 'jpeg', 'png', 'pdf');
    if (in_array($fileActualExt, $Allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNewName = $fileName . "." . uniqid('', true) . '.' . $fileActualExt;
                $fileDestination = '../images/' . $fileNewName;

                if (empty($posttitle) || empty($categorieschoose) || empty($file) || empty($message)) {
                    header("Location: ../addnewpost.php?submit=empty");
                    exit();
                } else {
                    $sql = "insert into addnewpost(post_title,category,author,image,post,datetime) values(?,?,?,?,?,?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../addnewpost.php?submit=SQLerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssss", $posttitle, $categorieschoose, $author, $fileNewName, $message, $datetime);
                        mysqli_stmt_execute($stmt);
                        move_uploaded_file($fileTmp, $fileDestination);
                        header("Location: ../addnewpost.php?submit=success");
                        exit();
                    }
                }
            } else {
                header("Location: ../addnewpost.php?submit=bigger_size");
                exit();
            }
        } else {
            header("Location: ../addnewpost.php?submit=error");
            exit();
        }
    } else {
        header("Location: ../addnewpost.php?submit=not_type");
        exit();
    }
}