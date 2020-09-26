<?php
include 'database_conn.inc.php';
include 'datetime.php';
session_start();

if (isset($_POST["submit"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
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
                    header("Location: ../editpost.php?edit=empty");
                    exit();
                } else {
                    $sql = "UPDATE addnewpost SET post_title = ?, category = ?, author = ?, `image` = ?, post = ?, `datetime` = ? where id = ?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../editpost.php?edit=SQLerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssssssi", $posttitle, $categorieschoose, $author, $fileNewName, $message, $datetime, $id);
                        mysqli_stmt_execute($stmt);
                        move_uploaded_file($fileTmp, $fileDestination);
                        header("Location: ../posts.php?edit=success");
                        exit();
                    }
                }
            } else {
                header("Location: ../editpost.php?edit=bigger_size");
                exit();
            }
        } else {
            header("Location: ../editpost.php?edit=error");
            exit();
        }
    } else {
        header("Location: ../editpost.php?edit=not_type");
        exit();
    }
} else {
    header("Location: ../editpost.php");
    exit();
}