<?php
    include_once '../../apis/internal/index.php';

    session_start();

    if (isset($_COOKIE['auth-token'])) {
        header('Location: ../pages/chat?auth-token=' . $_COOKIE['auth-token']);
    } else {
        unset($_COOKIE['login-time']);
        setcookie('login-time', null, -1, '/');
    }
?>
<html lang="en">
<head>
    <title>CHTR - Sign in</title>
    <link rel="stylesheet" type="text/css" href="../../stylesheets/styles.css">
</head>
<body>
<div style="height: 100%;display: flex;align-items: center;">
    <div class="signage">
        <div class="logo" style="margin-bottom: 40px;">
            <a>C H T R</a>
        </div>
        <div class="credentials" id="credentials_login">
            <form action="../../apis/auth/index.php" method="post" enctype="multipart/form-data">
                <table class="login" style="width:100%;">
                    <tr>
                        <td>
                            <p>Email or Username:</p>
                        </td>
                    </tr>
                    <tr class="spaceUnder">
                        <td>
                            <label>
                                <input type="text" style="width:100%;" name="username">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Password:</p>
                        </td>
                    </tr>
                    <tr class="spaceUnder">
                        <td>
                            <label>
                                <input type="password" style="width:100%;" name="password">
                            </label>
                        </td>
                    </tr>
                </table>
                <div style="margin: auto;text-align: center;">
                    <label for="remember-me" style="display: inline-block;vertical-align: middle;font-size:12px;">Remember
                        me </label>
                    <input type="checkbox" style="display: inline-block;vertical-align: middle;" name="remember-me"
                           id="remember-me" value="remember">
                </div>
                <button type="submit">LOGIN</button>
                <p style="font-size: 10px;">Dont have a user yet? <a style="color:black;text-decoration: underline;">Sign
                        up!</a></p>
                <?php if (isset($_SESSION['login-error'])) {
                    echo "<p style='color:darkred;font-size:10px;'>" . $_SESSION['login-error'] . "</p>";
                    unset($_SESSION['login-error']);
                } ?>
        </div>
        </form>
    </div>
</div>
</div>

</body>
</html>
