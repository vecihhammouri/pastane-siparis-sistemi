<?php
$user = $_POST["user"];
$pass = $_POST["pass"];
$radio = $_POST["whichuser"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
