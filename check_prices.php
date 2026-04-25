<?php
include "../config/db.php";
include "stock_prices.php";

$result = mysqli_query($conn, "SELECT * FROM alerts WHERE is_triggered = 0");

while ($alert = mysqli_fetch_assoc($result)) {

    $stock = $alert['stock_symbol'];
    $target = $alert['target_price'];
    $type = $alert['alert_type'];
    $current_price = $stock_prices[$stock];

    $trigger = false;

    if ($type == "above" && $current_price > $target) {
        $trigger = true;
    }

    if ($type == "below" && $current_price < $target) {
        $trigger = true;
    }

    if ($trigger) {
        mysqli_query(
            $conn,
            "UPDATE alerts SET is_triggered = 1 WHERE id = {$alert['id']}"
        );
    }
}
?>
