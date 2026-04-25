<?php
include "../config/db.php";

/* ===== PHPMailer configuration ===== */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';

/* ===== Fetch pending alerts ===== */
$query = "SELECT alerts.*, users.email 
          FROM alerts 
          JOIN users ON alerts.user_id = users.id
          WHERE is_triggered = 0";

$result = mysqli_query($conn, $query);

/* ===== Simulated stock price ===== */
$current_price = 200;


while ($row = mysqli_fetch_assoc($result)) {

    if ($current_price >= $row['target_price']) {

        $alert_id = $row['id'];
        $email    = $row['email'];
        $stock    = $row['stock_symbol'];
        $target   = $row['target_price'];

        /* ===== Update alert status ===== */
        mysqli_query(
            $conn,
            "UPDATE alerts SET is_triggered = 1 WHERE id = $alert_id"
        );

        /* ===== Send Email ===== */
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'p2209890169@gmail.com';   
            $mail->Password   = 'kvzx wrcq ywgm gwao';      
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('yourgmail@gmail.com', 'Stock Alert System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Stock Alert Triggered';
            $mail->Body    = "
                <h3>Stock Alert Triggered</h3>
                <p><b>Stock:</b> $stock</p>
                <p><b>Target Price:</b> ₹$target</p>
                <p><b>Current Price:</b> ₹$current_price</p>
            ";

            $mail->send();
            echo "Alert sent to $email<br>";

        } catch (Exception $e) {
            echo "Email error: {$mail->ErrorInfo}<br>";
        }
    }
}
?>
