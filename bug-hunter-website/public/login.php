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

        $password = $_POST['password'];
        
        if ($Error == "")
        {
            $arr['email'] = $email;
            $arr['password'] = $password;

            $query = "select * from users where email = :email && password = :password limit 1;";
            $stm = $connection->prepare($query);
            $check = $stm->execute($arr);

            if ($check){
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
                if(is_array($data) && count($data) > 0){
                    $data = $data[0];
                    $_SESSION['username'] = $data->username;
                    $_SESSION['url_address'] = $data->url_address;
                    header("Location: index.php");
                    die;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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
            <div id="title">Login</div>
            <input id="textbox" type="email" name="email" required><br>
            <input id="textbox" type="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </body>
</html>