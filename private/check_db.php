<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library2";

$conn = new mysqli($servername, $username, $password, $dbname);

// $host = "sql305.infinityfree.com"; // Check if this is correct
// $username = "if0_37579233";
// $password = "Lm7ofxqDNThxb2";
// $database = "if0_37579233_library";

// $conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    echo "ERROR";
} else {
    echo "OK";
}






?>
