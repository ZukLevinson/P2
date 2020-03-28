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

    function issue($id, $secret)
    {
        return $id . ":" . hash('sha256', $secret . $id);
    }

    function validate($token, $secret)
    {
        $parts = explode(":", $token);
        if ($parts[1] === hash('sha256', $secret . $parts[0]))
            return $parts[0];
        return null;
    }

    function get_messages($conn, $chat)
    {
        $sql = "SELECT * FROM Chat_$chat";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<a>Select a chat or create one.</a>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $text = $row['Text'];
                $time = $row['Time'];
                $sender = get_username(open_conn(), $row['Sender']);

                echo <<<EOT
            <table style="width:100%;margin-bottom:20px;height=60px;">
                <tr>
                    <td class="user">
                        $sender:
                    </td>
                    <td rowspan="2" class="time">
                        $time
                    </td>
                </tr>
                <tr>
                    <td class="message">
                        $text
                    </td>
                </tr>
            </table>
EOT;

            }
        }
    }

    function send_message($conn, $sender, $message, $chat_id)
    {
        $sql = "INSERT INTO Chat_$chat_id (Text, Sender) VALUES ('$message', $sender)";
        mysqli_query($conn, $sql);
        header('Location:../../pages/chat/?chat=' . $chat_id);
    }

    function get_chats($conn, $user_id)
    {
        $sql = "SELECT Chats FROM Users WHERE UserID = $user_id";
        $result = mysqli_query($conn, $sql);

        $chats = explode(',', mysqli_fetch_array($result)['Chats']);
        foreach ($chats as $chat_id) {
            $sql = "SELECT Image FROM Chats_Info WHERE ID=$chat_id";
            $image = mysqli_fetch_array(mysqli_query($conn, $sql))['Image'];
            $sql = "SELECT * FROM Chat_$chat_id ORDER BY ID DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);

            $chat_name = get_chat_name($conn, $chat_id);

            if (mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_array($result);

                $text = $row['Text'];
                $time = $row['Time'];
                $sender = get_username($conn, $row['Sender']);


                echo <<<EOT
                    <tr onclick="window.location='?chat=$chat_id'">
                        <td style="width:100%;">
                            <table style="margin-bottom:20px;" style="height:60px;">
                                <tr>
                                    <td class="room+time">
                                        $chat_name @ $time
                                    </td>
                                    <td class="photo" rowspan="2" style="width:100px;">
                                        <img width="60px" height="60px" src="../../files/images/status/$image" alt="$chat_name Status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="message">
                                        <b>$sender:</b> $text
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
EOT;
            } else {
                echo <<<EOT
                    <tr onclick="window.location='?chat=$chat_id'">
                        <td style="width:100%;">
                            <table style="margin-bottom:20px;" style="height:60px;">
                                <tr>
                                    <td class="room+time">
                                        $chat_name
                                    </td>
                                    <td class="photo" rowspan="2" style="width:100px;">
                                        <img width="60px" height="60px" src="../../files/images/status/$image" alt="$chat_name Status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="message">
                                        <b>No Massages</b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
EOT;

            }
        }

    }

    function get_users($conn, $chat_id)
    {
        $sql = "SELECT Participants FROM Chats_Info WHERE ID=$chat_id";
        $result = mysqli_query($conn, $sql);
        $users_id = mysqli_fetch_array($result)['Participants'];

        return ($users_id);
    }

    function get_chat_name($conn, $chat_id)
    {
        $sql = "SELECT Name FROM Chats_Info WHERE ID=$chat_id";
        $result = mysqli_query($conn, $sql);
        $chat_name = mysqli_fetch_array($result)['Name'];

        return ($chat_name);
    }

    function get_username($conn, $user_id)
    {
        $sql = "SELECT Username FROM Users WHERE UserID=$user_id";
        $result = mysqli_query($conn, $sql);
        $chat_name = mysqli_fetch_array($result)['Username'];

        return ($chat_name);
    }