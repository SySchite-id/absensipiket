<?php include("db.php"); ?>

<h2>Absensi Piket Gedung DKV</h2>

<!-- Check current count -->
<?php
$date = date("Y-m-d");
$result = $conn->query("SELECT COUNT(*) as count FROM attendance WHERE date='$date'");
$row = $result->fetch_assoc();
$active_count = $row['count'];

if ($active_count < 3) {
    echo '<form action="checkin.php" method="POST">
    <label>Name:</label>
    <input type="text" name="name" required><br>
    
    <label>Class:</label>
    <select name="class" required>
        <option value="X DKV 1">X DKV 1</option>
        <option value="X DKV 2">X DKV 2</option>
        <option value="XI DKV 1">XI DKV 1</option>
        <option value="XI DKV 2">XI DKV 2</option>
        <option value="XII DKV 1">XII DKV 1</option>
        <option value="XII DKV 2">XII DKV 2</option>
    </select><br>

    <label>Activity Plan:</label>
    <textarea name="activity" required></textarea><br>

    <button type="submit">Check In</button>
</form>';
} else {
    echo "<p>Maximum 3 people have already checked in today.</p>";
}
?>

<!-- Check-out Form -->
<form action="checkout.php" method="POST" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Class:</label>
    <select name="class" required>
        <option value="X DKV 1">X DKV 1</option>
        <option value="X DKV 2">X DKV 2</option>
        <option value="XI DKV 1">XI DKV 1</option>
        <option value="XI DKV 2">XI DKV 2</option>
        <option value="XII DKV 1">XII DKV 1</option>
        <option value="XII DKV 2">XII DKV 2</option>
    </select><br>

    <label>Upload Checkout Image:</label>
    <input type="file" name="checkout_image" accept=".jpg,.jpeg,.png" required><br>

    <button type="submit">Check Out</button>
</form>


<!-- View Status -->
<a href="status.php">View Current Status</a>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Piket</title>
</head>
<body>
    <h1>Absensi Piket Gedung Multimedia</h1>
    <h3>Form Check-in dan Check-out Absensi Piket Gedung Multimedia</h3>
    <h4 style="color: red;">Silahkan absen setiap awal dan akhir periode piket!</h4>
    
    <div class="checkin">
        <a href="checkin.php">
            Check-in
        </a>
    </div>
    
    <div class="checkout">
        <a href="checkout.php">
            Check-out
        </a>
    </div>
</body>
</html> -->