<?php
// prevent script injection
if (!isset($_GET['dir'])) {
    header('Location: index.php');
    exit();
}
$_GET['dir'] = htmlspecialchars($_GET['dir']);

// recieves dir
$folder = $_GET['dir'];
$file = "TOs/" . $folder . "/Plenum_to.json";
$json = file_get_contents($file);

// decode json to array
$json_data = json_decode($json, true);

?>

<head>
    <meta charset="UTF-8">
    <title>Download</title>
    <link rel="stylesheet" href="sds-to-style.css">
</head>

<body>
    <script src="sds-to-functions.js"></script>
    <script style="display: none;">
        var dir = window.location.href.split('?')[1].split('=')[1];
        renderMarkDown(dir + '/Plenum', download);

        // go to index.php after 1 second
        setTimeout(function () {
            window.location.href = "index.php?dir=" + dir + "/Plenum";
        }, 1000);
    </script>
</body>