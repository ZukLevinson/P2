<?php
    include_once '../internal/index.php';
    session_start();
    $conn = open_conn();

    if (isset($_GET['auth-token'])) { //if there is a auth
        $secret = file_get_contents('private/secret.txt');
        $validation = validate($_GET['auth-token'], $secret);

        if ($validation != null) { //if validation ok
            $_SESSION['user-id'] = $validation;
            header('Location:../../pages/chat/?chat=0'); //go to chats page
        } else {
            header('Location:../../pages/sign/'); //go back to sign in
        }

    } else {
        header('Location:../../pages/sign/');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!empty($_POST['username']) and !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password_raw = $_POST['password'];
            $password_enc = hash('SHA256', $password_raw);

            $sql = "SELECT * FROM Users WHERE (Username ='$username' OR Email ='$username') AND Password='$password_enc'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) != 0) { //if there is a user
                if (isset($_POST['remember-me'])) {
                    $secret = file_get_contents('private/secret.txt');
                    setcookie('auth-token', issue($_SESSION['user-id'], $secret), time() + 3600, '/', NULL, 0);
                }

                //get user credentials
                $row = mysqli_fetch_array($result);
                $_SESSION['user-id'] = $row['UserID'];
                $_SESSION['username'] = $row['UserName'];
                $_SESSION['user-email'] = $row['Email'];

                header('Location:../../pages/chat/?chat=0'); //go to chats page
            } else {
                $_SESSION['login-error'] = 'Username or password are incorrect.';
                header('Location:../../pages/sign/');
            }
        } else {
            $_SESSION['login-error'] = 'Enter username and password.';
            header('Location:../../pages/sign/');
        }
    }

