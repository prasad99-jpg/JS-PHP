<?php
session_start();
include "../config/db.php";
include "check_alerts.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['save_alert'])) {

    $stock = trim($_POST['stock']);
    $price = floatval($_POST['price']);
    $type  = $_POST['alert_type'];

    if (empty($stock) || empty($price) || empty($type)) {
        echo "<p class='error'>All fields are required</p>";
    } else {

        $stmt = mysqli_prepare($conn,
            "INSERT INTO alerts (user_id, stock_symbol, target_price, alert_type)
             VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "isds", $user_id, $stock, $price, $type);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p class='success'>Alert created successfully!</p>";
        } else {
            echo "<p class='error'>Error creating alert</p>";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/validation.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div id="loader">Loading...</div>
<?php include "../includes/header.php"; ?>

<div class="container">

<div class="dashboard">

    <!-- Welcome -->
    <div class="card full-width">
        <h2>Welcome,<?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
    </div>

   <!-- Action Buttons -->
    <div class="card full-width center">
    <a href="../pages/learn_more.php" class="action-btn">Learn More</a>
    <a href="../pages/about_us.php" class="action-btn">About Us</a>
    </div>

    <!-- Stock Prices -->
    <div class="card">
        <h3>Current Stock Prices</h3>
        <ul class="stock-list" id="stockList">
        <?php
        $stockList = mysqli_query($conn, "SELECT * FROM stocks");
        while ($row = mysqli_fetch_assoc($stockList)) {
        echo "<li>
            <span>{$row['symbol']}</span>
            <span>₹{$row['current_price']}</span>
          </li>";
        }
        ?>
        </ul>
    </div>

    <!-- Create Alert -->
    <div class="card">
        <h3>Create Stock Alert</h3>

        <form method="POST" onsubmit="return validateAlertForm();" class="form-grid">

            <div class="form-group">
                <label>Stock</label>
                <select name="stock" required>
                <option value="">Select</option>

                <?php
                $stockDropdown = mysqli_query($conn, "SELECT * FROM stocks");
                while ($row = mysqli_fetch_assoc($stockDropdown)) {
                echo "<option value='{$row['symbol']}'>{$row['company_name']}</option>";
                }
                ?>
                </select>
            </div>

            <div class="form-group">
                <label>Target Price</label>
                <input type="number" name="price" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Alert Type</label>
                <select name="alert_type" required>
                    <option value="above">Above</option>
                    <option value="below">Below</option>
                </select>
            </div>

            <button type="submit" name="save_alert">Create Alert</button>
        </form>
    </div>

    <!-- Alerts Table -->
    <div class="card full-width">
        <h3>Your Alerts</h3>

        <table>
            <tr>
                <th>Stock</th>
                <th>Target</th>
                <th>Type</th>
                <th>Status</th>
            </tr>

           <?php
           $result = mysqli_query($conn, "SELECT * FROM alerts WHERE user_id='$user_id' ORDER BY id DESC");

           while ($row = mysqli_fetch_assoc($result)) {

           $statusClass = $row['is_triggered'] ? 'status-triggered' : 'status-pending';
           $statusText  = $row['is_triggered'] ? 'Triggered' : 'Pending';

           echo "<tr>
            <td>" . htmlspecialchars($row['stock_symbol']) . "</td>
            <td>₹" . htmlspecialchars($row['target_price']) . "</td>
            <td>" . htmlspecialchars($row['alert_type']) . "</td>
            <td class='$statusClass'>$statusText</td>
           </tr>";
           }
           ?>
        </table>
    </div>

    <!-- Logout -->
    <div class="card full-width center">
        <a class="logout-btn" href="../auth/logout.php">Logout</a>
    </div>

</div>
</div>
<script>
let firstLoad = true;

function loadStocks() {

    if (firstLoad) {
        document.getElementById("loader").style.display = "flex";
    }

    fetch("get_stocks.php")
        .then(response => response.json())
        .then(data => {

            let html = "";

            data.forEach(stock => {
                html += `
                <li>
                    <span>${stock.symbol}</span>
                    <span style="color:#00ff99;">
                        <i class="fas fa-arrow-up"></i> ₹${stock.current_price}
                    </span>
                </li>`;
            });

            document.getElementById("stockList").innerHTML = html;

            document.getElementById("loader").style.display = "none";
            firstLoad = false;
        });
}
// run every 5 seconds
setInterval(loadStocks, 5000);

// run once on page load
loadStocks();
</script>
<script>
function checkAlerts() {
    fetch("get_alerts.php")
        .then(res => res.json())
        .then(data => {

            if (data.length > 0) {
                let message = "Alerts Triggered:\n";

                data.forEach(alert => {
                    message += `${alert.stock_symbol} hit ₹${alert.target_price}\n`;
                });

                alert(message);
            }
        });
}
setInterval(checkAlerts, 5000);
</script>
</body>
</html>
