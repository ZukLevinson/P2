<?php
    include_once '../../apis/internal/index.php';

    session_start();

    $conn = open_conn();
    if (!isset($_COOKIE['auth-token'])) {
        header('Location: ../../');
        exit;
    } else {
        $token = $_COOKIE['auth-token'];
    }
    $secret = file_get_contents('../../apis/auth/private/secret.txt');

    if (isset($_GET['chat'])) {
        $_SESSION['current-chat'] = $_GET['chat'];
    } else {
        $_SESSION['current-chat'] = 0;
    }

    if (isset($_POST['message'])) {
        send_message($conn, $_SESSION['user-id'], $_POST['message'], $_SESSION['current-chat']);
    }
    close_conn($conn);
?>

<html lang="en">
<head>
    <title>CHTR</title>
    <link rel="stylesheet" type="text/css" href="../../stylesheets/styles.css">
<!--</head>-->
<body>
<div>
    <div class="side_menu inline">
        <div class="header">
            <div class="logo">
                <a>C H T R</a>
            </div>
            <div class="menu">
                <div>
                    <a style="margin-top:2px;">Chats</a>
                </div>
                <div>
                    <a style="margin-top:2px;">Friends</a>
                </div>
                <div>
                    <a style="margin-top:2px;">Settings</a>
                </div>
            </div>
        </div>
        <div class="information">
            <table style="width:100%;">

                <?php get_chats(open_conn(), $_SESSION['user-id']); ?>

            </table>
        </div>
        <div class="footer" style="text-align:center;background-image:linear-gradient(to right, transparent, white);">
            &#169; All rights reserved to Zuk Levinson 2020
        </div>
    </div>
    <div class="chat inline">
        <div class="header">
            <table style="width:100%;height:40px;">
                <tr>
                    <td rowspan="2" style="width:8px;">
                        <div class="line"></div>
                    </td>
                    <td>
                        <a class="title"
                           style="font-size: 26px;"><?php echo get_chat_name(open_conn(), $_SESSION['current-chat']); ?></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a><?php echo get_users(open_conn(), $_SESSION['current-chat']); ?></a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="communication" id="chat">
            <div class="fade_up">

            </div>

            <?php get_messages(open_conn(), $_SESSION['current-chat']); ?>

            <div class="fade_down">

            </div>
        </div>

        <form class="messenger" method="post">
            <label style="width:100%;">
                <textarea name="message" style="width:100%;display: inline-block;"></textarea>
            </label>
            <button type="submit" style="display: inline-block;">Send</button>
        </form>
    </div>
</div>
<script>
    document.getElementById("chat").scrollTop = document.getElementById("chat").scrollHeight;
</script>
</body>
</html>
