<?php
include("db.php");

$date = date("Y-m-d");
$result = $conn->query("SELECT name, check_in, check_out, checkout_image FROM attendance WHERE date='$date'");

echo "<h2>Attendance Status for $date</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['name']} - Check-in: {$row['check_in']} - Check-out: " . ($row['check_out'] ? $row['check_out'] : "Not checked out") . "</p>";
    
    // Display uploaded image if available
    if ($row['checkout_image']) {
        echo "<img src='{$row['checkout_image']}' width='100' alt='Check-out Image'><br>";
    }
}
?>
