<?php
    session_start();
    if(isset($_POST["log-in"])){
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];

        try{
            $connection = new mysqli("containers-us-west-72.railway.app",'root', "NwRz7MaIz80oJvoEcTWD", "railway","7974");
            $query = "SELECT id, username, password FROM members";
            $result = $connection->query($query);
            $userLogInData = [];

            while($row = $result->fetch_assoc()){
                $userLogInData = [
                    [
                        "id" => $row["id"],
                        "username" => $row["username"],
                        "password" => $row["password"]
                    ],
                    ...$userLogInData,
                ];
            };

            $target = array_filter($userLogInData, function($user){
                GLOBAL $username, $password;
                return $user["username"] === $username && $user["password"] === $password;
            });

            

            if(count($target) <= 0){
                $_SESSION["loginProcess"] = false;
                header("Location:../index.php");
            }else{
                setcookie("user", json_encode(array_values($target)[0]), time() + 60 * 60 * 24 * 15,"/");
                header("Location:../pages/dashboard.php");
            }

        }catch(Exception $err){
            $_SESSION["loginProcess"] = false;
            header("Location:../index.php");
        }
    }
?>