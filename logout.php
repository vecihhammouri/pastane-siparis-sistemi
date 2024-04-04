<?php
require_once("includes/config.php");
if (!isset($_SESSION["uname"]) && !isset($_SESSION["psw"])) {
    header("Location: login.php");
}
session_destroy();
header("Location: login.php");