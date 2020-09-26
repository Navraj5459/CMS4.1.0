<?php

function Redirect($NewLocation)
{
    header("Location: ../" . $NewLocation);
    exit();
}

function ErrorMessage()
{
    if (isset($_SESSION["ErrorMessage"])) {
        $output = '<div class="display-error">' . htmlentities($_SESSION["ErrorMessage"]) . '</div>';
        $_SESSION["ErrorMessage"] = null;
        return $output;
    }
}

function SuccessMessage()
{
    if (isset($_SESSION["SuccessMessage"])) {
        $output = '<div class="display-error">' . $_SESSION["SuccessMessage"] . '</div>';
        $_SESSION["SuccessMessage"] = null;
        return $output;
    }
}

function session_login()
{
    if (isset($_SESSION["u_id"])) {
        return true;
    } else {
        header("Location: login.php?login=required");
        exit();
    }
}

function PostsDashboard()
{
    include 'database_conn.inc.php';
    $sql = "SELECT COUNT(id) FROM addnewpost;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: dashboard.php?count=sqleror");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo $row['COUNT(id)'];
    }
}

function CategoriesDashboard()
{
    include 'database_conn.inc.php';
    $sql = "SELECT COUNT(id) FROM categories;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: dashboard.php?count=sqleror");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo $row['COUNT(id)'];
    }
}

function AdminsDashboard()
{
    include 'database_conn.inc.php';
    $sql = "SELECT COUNT(id) FROM admins;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: dashboard.php?count=sqleror");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo $row['COUNT(id)'];
    }
}

function CommentsDashboard()
{
    include 'database_conn.inc.php';
    $sql = "SELECT COUNT(id) FROM comments;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: dashboard.php?count=sqleror");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo $row['COUNT(id)'];
    }
}

function ApprovedComments($id)
{
    include 'database/database_conn.inc.php';
    $status = "ON";
    $sql = "SELECT COUNT(id) FROM comments WHERE `status` = ? AND post_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "You have a SQL Error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo '<span>' . $row["COUNT(id)"] . '</span>';
    }
}

function DisApprovedComments($id)
{
    include 'database/database_conn.inc.php';
    $status = "OFF";
    $sql = "SELECT COUNT(id) FROM comments WHERE `status` = ? AND post_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "You have a SQL Error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        echo '<span>' . $row["COUNT(id)"] . '</span>';
    }
}