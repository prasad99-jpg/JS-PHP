<?php
session_start();
include "../config/db.php";

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,
    "SELECT * FROM alerts WHERE user_id='$user_id' AND is_triggered=1 AND seen=0"
);

$alerts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $alerts[] = $row;

    // mark as seen
    mysqli_query($conn, "UPDATE alerts SET seen=1 WHERE id={$row['id']}");
}

echo json_encode($alerts);