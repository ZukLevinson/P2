<?php
    function open_conn()
    {
        $db_host = '192.168.1.17';
        $db_username = 'root';
        $db_password = '$jhuVig1572#';
        $db_name = 'P2';

        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);// or die("Connect failed: %s\n". $conn -> error)

        if (mysqli_connect_errno()) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        return $conn;
    }

    function close_conn($conn)
    {
        $conn->close();
    }

    function issue($id, $secret){
        return $id . ":" . hash('sha256', $secret . $id);
    }

    function validate($token, $secret){
        $parts = explode(":", $token);
        if ($parts[1] === hash('sha256', $secret . $parts[0]))
            return $parts[0];
        return null;
    }