<?php
ob_start();
session_start();
$_SESSION["email"] = $_POST["email"];
$_SESSION["password"] = $_POST["password"];
header("location: ../area_personale/area_personale.php");
ob_end_clean();