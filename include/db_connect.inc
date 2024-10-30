<?php
//Check what server you are accessing
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "root";
    $password = "";
    $dbname = "pets";
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "s4073476";
    $password = "123_You_123";
    $dbname = "s4073476";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
