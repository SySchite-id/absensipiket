<?php
include("db.php");

$name = $_POST['name'];
$class = $_POST['class'];
$activity = isset($_POST['activity']) ? $_POST['activity'] : null; // No validation
$date = date("Y-m-d");
$time = date("Y-m-d H:i:s");

$allowed_classes = ["X DKV 1", "X DKV 2", "XI DKV 1", "XI DKV 2", "XII DKV 1", "XII DKV 2"];

if (!in_array($class, $allowed_classes)) {
    echo "<p>Invalid class selection! Redirecting in <span id='countdown'>3</span> seconds...</p>";
} else {
    $check = $conn->prepare("SELECT COUNT(*) as count FROM attendance WHERE date=?");
    $check->bind_param("s", $date);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();

    if ($result['count'] >= 3) {
        echo "<p>Check-in limit reached for today! Redirecting in <span id='countdown'>3</span> seconds...</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO attendance (name, class, activity, date, check_in) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $class, $activity, $date, $time);
        $stmt->execute();

        echo "<p>Check-in successful! Redirecting in <span id='countdown'>3</span> seconds...</p>";
    }
}
?>

<script>
    let countdown = 3;
    setInterval(() => {
        countdown--;
        document.getElementById('countdown').innerText = countdown;
        if (countdown === 0) {
            window.location.href = "index.php";
        }
    }, 1000);
</script>



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
    
    <div class="form-checkin">
        <form action="submit_data_checkin" method="post">
        <div class="box-checkin">

            <h3>Silahkan isi Data Diri</h3>
            <h4>Nama</h4>
            <p>Silahkan masukkan nama lengkap!</p>
            <input type="text" name="nama" id="nama" required>
            
            <h4>Kelas</h4>
            <input type="radio" name="kelas" id="xdkv1" value="X DKV 1" required>
            <label for="kelas">X DKV 1</label><br>
            <input type="radio" name="kelas" id="xdkv2" value="X DKV 2">
            <label for="kelas">X DKV 2</label><br>
            <input type="radio" name="kelas" id="xidkv1" value="XI DKV 1">
            <label for="kelas">XI DKV 1</label><br>
            <input type="radio" name="kelas" id="xidkv2" value="XI DKV 2">
            <label for="kelas">XI DKV 2</label><br>
            <input type="radio" name="kelas" id="xiidkv1" value="XII DKV 1">
            <label for="kelas">XII DKV 1</label><br>
            <input type="radio" name="kelas" id="xiidkv2" value="XII DKV 2">
            <label for="kelas">XII DKV 2</label><br>

            <h4>Rencana Kegiatan</h4>
            <p>Silahkan isi rencana kegiatan</p>
            <input type="text" name="kegiatan" id="kegiatan" required><br>
            
            <button type="submit"><a href="submit-checkin">Submit</a></button>
        </div>
        </form>
    </div>
        

</body>
</html> -->