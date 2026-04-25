<?php
include "../config/db.php";

$stocks = mysqli_query($conn, "SELECT * FROM stocks");

$data = [];

while ($row = mysqli_fetch_assoc($stocks)) {
    $data[] = $row;
}

// convert PHP array → JSON
echo json_encode($data);