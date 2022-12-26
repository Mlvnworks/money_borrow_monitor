<?php   
session_start();
    if(isset($_POST["update"])){
        $inputAmount = $_POST["amount"];
        $userId = $_SESSION["userId"] * 1;
        

        try{
            $connection = new mysqli("containers-us-west-72.railway.app",'root', "NwRz7MaIz80oJvoEcTWD", "railway","7974");
            
            function getCurrentBalance(){
                global $connection,$userId;
                $result =  $connection -> query("SELECT * FROM members WHERE id=".$userId);
                while($row = $result->fetch_assoc()){   
                    return $row;
                }
                
            } 


            // var_dump($_POST["action"]);
            $toUpdate = $_POST["action"] === "1" ? (getCurrentBalance()["bar_balance"] * 1) + $inputAmount :(getCurrentBalance()["bar_balance"] * 1) - $inputAmount ;

            $updateBalance = "UPDATE members SET bar_balance=".$toUpdate." WHERE id=". $userId; 
            
            $connection -> query($updateBalance);

            $connection->close();

        }catch(Exception $err){

            $_SESSION["updateAmountError"] = true;

        }

    }else{
        $_SESSION["updateAmountError"] = true;

    }

    header("Location:../pages/dashboard.php");
?>