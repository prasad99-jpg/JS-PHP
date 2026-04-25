<?php
include "../config/db.php";

// get all alerts
$alerts = mysqli_query($conn, "SELECT * FROM alerts WHERE is_triggered = 0");

while ($row = mysqli_fetch_assoc($alerts)) {

    $stock = $row['stock_symbol'];
    $target = $row['target_price'];
    $type = $row['alert_type'];

    // get current price
    $stockData = mysqli_query($conn, "SELECT current_price FROM stocks WHERE symbol='$stock'");
    $stockRow = mysqli_fetch_assoc($stockData);

    $current = $stockRow['current_price'];

    $trigger = false;

    if ($type == "above" && $current >= $target) {
        $trigger = true;
    }

    if ($type == "below" && $current <= $target) {
        $trigger = true;
    }

    if ($trigger) {

        // mark as triggered
        mysqli_query($conn, "UPDATE alerts SET is_triggered=1 WHERE id='{$row['id']}'");

        // TODO: send SMS here (next step)
    }
}
?>