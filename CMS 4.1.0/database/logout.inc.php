<?php
// include_once 'database_conn.inc.php';
//login seccion must be null before session end
session_start();
$_SESSION["u_id"] = null;
$_SESSION["u_datetime"] = null;
$_SESSION["u_username"] = null;
$_SESSION["u_name"] = null;
$_SESSION["u_addedby"] = null;
// session_unset();
session_destroy();
header("Location: ../login.php");