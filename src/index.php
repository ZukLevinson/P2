<?php
    session_start();

    if (isset($_COOKIE['auth-token'])) {
        header('Location: apis/auth/?auth-token=' . $_COOKIE['auth-token']);
    } else {
        header('Location: pages/sign');
    }
?>

<html lang="en">
<head>
    <title>CHTR</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/styles.css">
</head>
<body>

</body>
</html>
