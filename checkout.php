<?php
include("db.php");

$name = $_POST['name'];
$class = $_POST['class'];
$date = date("Y-m-d");
$time = date("Y-m-d H:i:s");

$allowed_classes = ["X DKV 1", "X DKV 2", "XI DKV 1", "XI DKV 2", "XII DKV 1", "XII DKV 2"];

if (!in_array($class, $allowed_classes)) {
    echo "<p>Invalid class selection! Redirecting in <span id='countdown'>3</span> seconds...</p>";
} else {
    $check = $conn->prepare("SELECT check_in, check_out FROM attendance WHERE name=? AND class=? AND date=?");
    $check->bind_param("sss", $name, $class, $date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        echo "<p>You haven't checked in today! Redirecting in <span id='countdown'>3</span> seconds...</p>";
    } else {
        $row = $result->fetch_assoc();

        if ($row['check_out']) {
            echo "<p>You have already checked out! Redirecting in <span id='countdown'>3</span> seconds...</p>";
        } else {
            $target_dir = "uploads/" . $date . "/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
            $file_type = mime_content_type($_FILES['checkout_image']['tmp_name']);

            if (!in_array($file_type, $allowed_types)) {
                echo "<p>Invalid file format! Only JPG, PNG, and JPEG are allowed. Redirecting in <span id='countdown'>3</span> seconds...</p>";
            } else {
                $image_name = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "_", $name) . ".jpg";
                $target_file = $target_dir . $image_name;

                if (move_uploaded_file($_FILES["checkout_image"]["tmp_name"], $target_file)) {
                    $stmt = $conn->prepare("UPDATE attendance SET check_out=?, checkout_image=? WHERE name=? AND class=? AND date=?");
                    $stmt->bind_param("sssss", $time, $target_file, $name, $class, $date);
                    $stmt->execute();

                    echo "<p>Check-out successful! Redirecting in <span id='countdown'>3</span> seconds...</p>";
                } else {
                    echo "<p>Error uploading image. Redirecting in <span id='countdown'>3</span> seconds...</p>";
                }
            }
        }
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
    
    <div class="form-checkout">
        <form action="submit_data_checkout" method="post">
        <div class="box-checkout">

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

            <h4>Dokumentasi Kegiatan</h4>
            <p>Silahkan kirim foto/video dokumentasi kegiatan</p>
            <input type="file" name="dokumentasi" id="dokumentasi" required><br>
            
            <button type="submit"><a href="submit-checkout">Submit</a></button>
        </div>
        </form>
    </div>
        

</body>
</html> -->