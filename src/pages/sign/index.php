<?php
    include_once '../../apis/internal/index.php';

    session_start();

    if (isset($_COOKIE['auth-token'])) {
        header('Location: ../chat/?chat=0');
    }
?>
<html lang="en">
<head>
    <title>CHTR - Sign in</title>
    <link rel="stylesheet" type="text/css" href="../../stylesheets/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../../scripts/functions.js"></script>
</head>
<body>
<div style="height: 100%;display: flex;align-items: center;">
    <div class="signage">
        <div class="logo" style="margin-bottom: 40px;">
            <a>C H T R</a>
        </div>
        <div class="credentials" id="sign_in" style="display: block;">
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
                <p style="font-size: 10px;">
                    Dont have a user yet? <a style="color:black;text-decoration: underline;"
                                             onclick="popUp('sign_up','sign_in')">Sign up!</a>
                </p>
                <?php if (isset($_SESSION['login-error'])) {
                    echo "<p style='color:darkred;font-size:10px;'>" . $_SESSION['login-error'] . "</p>";
                    unset($_SESSION['login-error']);
                } ?>
            </form>
        </div>
        <div class="credentials" id="sign_up" style="display: none;">
            <form action="../../apis/auth/index.php" method="post" enctype="multipart/form-data">
                <table class="login" style="width:100%;">
                    <tr>
                        <td>
                            <p>Email:</p>
                        </td>
                    </tr>
                    <tr class="spaceUnder">
                        <td>
                            <label>
                                <input type="text" style="width:100%;" name="email">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Username:</p>
                        </td>
                    </tr>
                    <tr class="spaceUnder">
                        <td>
                            <label>
                                <input type="text" style="width:100%;" name="user">
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
                </div>
                <button type="submit">SIGN UP</button>
                <p style="font-size: 10px;">
                    Have a user? <a style="color:black;text-decoration: underline;"
                                        onclick="popUp('sign_up','sign_in')">Sign in!</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
