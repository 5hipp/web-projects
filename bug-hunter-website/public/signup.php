<?php

    require "../private/autoload.php";
    $Error = "";

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $email = $_POST['email'];
        if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $email))
        {
            $Error = "Please enter a valid email.";
        }

        $date = date("Y-m-d H:i:s");
        $url_address = get_random_string(60);

        $username = trim($_POST['username']);
        if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
        {
            $Error = "Please enter a valid username.";
        }
        $username = esc($username);

        $password = esc($_POST['password']);
        
        if ($Erorr == "")
        {
            //$query = "insert into users (url_address,username,email,password,date) values ('$url_address','$username','$email','$password','$date')";
            $query = "insert into users (url_address,username,email,password,date) values (:url_address,:username,:email,:password,:date)";

            mysqli_query($connection, $query);

            header("Location: login.php");
            die;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
    </head>
    <body style="font-family: verdana">
        <style type="text/css">
            form{
                margin: auto;
                border: solid thin #aaa;
                padding: 6px;
                max-width: 200px;
            }

            #title{
                background-color: #f1404c;
                padding: 0.5em;
                text-align: center;
            }

            #textbox{
                border: solid thin #aaa;
                margin-top: 4px;
                width: 98%:
            }
        </style>
        <form method="post">
            <div><?php 
                if(isset($Error) && $Error != "")
                {
                    echo $Error;
                }
            ?></div>
            <div id="title">Signup</div>
            <input id="textbox" type="text" name="username" required><br>
            <input id="textbox" type="email" name="email" required><br>
            <input id="textbox" type="password" name="password" required><br><br>
            <input type="submit" value="Signup">
        </form>
    </body>
</html>