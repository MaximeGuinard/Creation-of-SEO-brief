<?php
$file = isset($_GET['file']) ? $_GET['file'] : '';

if (empty($file) || !file_exists('/tool.dev-maxime-guinard.fr/brief/edito/' . $file)) {
    die('Brief not found.');
}

$brief = file_get_contents('/tool.dev-maxime-guinard.fr/brief/edito/' . $file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brief Generated</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .logo {
            display: block;
            margin: 20px auto;
            width: 100px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Brief Généré</h1>
    <img src="logo-generating.png" alt="En génération" class="logo">
    <div class="content">
        <h2>Votre brief généré :</h2>
        <pre><?php echo htmlspecialchars($brief); ?></pre>
    </div>
</body>
</html>
