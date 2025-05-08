<?php 
    if (!str_contains($_SERVER['REQUEST_URI'], ".php")) {
        header("Location: /index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>
    <title>Cargador de pelis</title>
</head>
<body>
    <?php require_once "form.php" ?>
</body>
</html>