<?php
    session_start();
    $firstName = $_SESSION["signedUp"]['firstName'];
    $result = $_SESSION["signedUp"]['signedUp'];
    $proccess = $result ? true : false;
    $_SESSION["signedUp"] ="";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=PT+Serif&display=swap');
        *,
        ::before,
        ::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
        :root {
            --primary: #c7bfd3;
            --secondary: #b7294a;
        }

        body {
            background-color: var(--secondary);
            font-family: 'PT Serif', serif;
            color: #fff;
        }

        .icon-container{
            height: clamp(350px, 55vh, 600px);
            display: flex;
        }
        .icon-container > svg{
            margin: auto;
        }

        #act{
            text-align: center;
            font-size: clamp(1.1rem, 2.3vw, 3.7rem);
        }

        #act > p{
            margin-block: 1.5rem;
        }
        #act > a{
            background-color: var(--primary);
            color: var(--secondary);
            font-weight: 700;
            font-size: clamp(1rem, 1.5vw, 2.4rem);
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 300ms;
            text-decoration: none;
        }

        #act > a{
            background-color: #fff;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <main>
        <div class="icon-container">
            <?php 
                if($proccess) include "../assets/check.svg";
                else include "../assets/x.svg";
            ?>
        </div>
        <div id="act">
            <p><?php  echo $proccess ? "You Have Successfully Signed Up. You May Now Log in.":"You Have Failed To Signed Up. Please Try Again Later." ?></p>
            
            <a href="<?php echo $proccess ? "../index.php" : "./signup.php"?>"><?php echo $proccess ? "Log-in" : "Try Again"?></a>
        </div>
    </main>
</body>
</html>