<?php
$files = glob("reports/*.pdf");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Reports</title>
</head>
<body>
    <h2>Attendance Reports</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <a href="<?= $file ?>" download><?= basename($file) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">Back to Home</a>
</body>
</html>
