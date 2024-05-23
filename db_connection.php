<?php
// Connection details
$host = "localhost";
$user = "musare";
$pass = "joseph";
$database = "online_user_research_workshops_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>