<?php
    session_start();
    $error = false;

    if(isset($_SESSION["updateAmountError"])){
        $error = $_SESSION["updateAmountError"];
    }

    $_SESSION["updateAmountError"] = false;

    if(isset($_COOKIE["user"])){
        $user = json_decode($_COOKIE["user"], true);
        $_SESSION["userId"] = $user["id"];
        $username = null;
        $balance = null;

        try{   
            $connection = new mysqli("containers-us-west-72.railway.app",'root', "NwRz7MaIz80oJvoEcTWD", "railway","7974");
            $query = "SELECT username, bar_balance FROM members WHERE id=".$user["id"];

            $row = $connection->query($query);
            while($result = $row->fetch_assoc()){
                $username = $result["username"];
                $balance = $result["bar_balance"];
            }
        }catch(Exception $err){
           $error = true;
        }
    }else{
        header("Location: ../login.php");
    };
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
            background-color: var(--primary);
            font-family: 'PT Serif', serif;
            color: #fff;
            transition: all 350ms;
        }

        .datas::before{
            content: attr(data-text);
        }

        header{
            background-color: var(--secondary);
            font-family: inherit;
            color: var(--primary);
            padding:15px;
            box-shadow: 2px 2px 7px #333;
            z-index: 2;
        }

        main{
            display: flex;
        }

        .side-bar{
            position: fixed;
            left: 0;
            width: clamp(175px, 18%, 700px);
            height: clamp(600px, 100vh, 100vh);
            background-color: var(--secondary);
            color: #fff;
            text-align: center;
            padding: 15px;
        }

        .side-bar > #name-icon{
            background-color: var(--primary);
            color: var(--secondary);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-inline: auto;
            margin-block: 2.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(2rem, 3vw, 4.3rem);
            font-weight: 900;
        }

        .side-bar > p{
            font-size: clamp(1.4rem, 2vw, 3rem);
        }

        #balance-area{
            margin-left: clamp(175px, 18%, 700px);
            text-align: center;
        }

        #balance-area > div{
            padding: 15px;
            background-color: #fff;
            color: var(--secondary);
            width:clamp(300px, 20vw, 600px);
            margin:1.4rem;
            border-radius: 8px;
            box-shadow: 3px 3px 8px #222;
            cursor: pointer;
            text-align: start;
        }

        #balance-area > div > #balance{
            font-size: clamp(2rem, 3vw, 4.3rem);
            text-align: center;
        }


        #balance-area >  button{
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: clamp(2rem, 3vw, 4.3rem);
            color: var(--primary);
            background-color: var(--secondary);
            margin-inline: 1.5rem;
            cursor: pointer;
            border: none;
            box-shadow: 3px 3px 8px #444;
        }

        #balance-area >  button:active{
            scale: .97;
        }

        /* Modal */
        .modal{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            background-color: rgba(50, 50, 50, .7);
            display: flex;
            display: none;
        }
        .modal > div{
            margin: auto;
            position: relative;
            width:clamp(260px, 30vw, 700px);
            background-color: var(--secondary);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 3px 3px 8px #444;
            text-align: center;
            height: clamp(220px, 40vh, 600px);
        }

        .modal > div > button{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: clamp(1.3rem, 2.1vw, 3.3rem);
            color: var(--secondary);
            background-color: var(--primary);
            margin-inline: 1.5rem;
            cursor: pointer;
            border: none;
            box-shadow: 3px 3px 8px #444; 
            position: absolute;
            top: 5px;
            right: 0px;
        }
        .modal > div >form> #action{
            display: none;
        }

        .modal > div >form>  input{
            display: block;
            border: none;
            outline: none;
            font-size: clamp(1rem, 1.7vw, 3rem);
            padding: 15px;
            border-radius: 8px;
            margin-block: 3rem;
            text-align: center;
            margin-inline: auto;
        }

        .modal > div >form>  input[type=submit]{
            background-color: var(--primary);
            color: var(--secondary);
            font-family: inherit;
            cursor: pointer;
            transition: all 300ms;
        }

        .modal > div >form>  input[type=submit]:hover{
            background-color: #fff;
        }

        .modal > div >form>  input[type=submit]:active{
            scale: .97;
        }
        .modal > div >form>span{
            position: absolute;
            left: 15px;
            top: 70px;
            font-weight: 900;
            font-size: clamp(1.3rem, 2.1vw, 3.3rem);
        }

        #alert{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            display:flex;
            background-color: rgba(25, 25, 25, .8);
            display: none;
        }

        #alert > div{
            margin: auto;
            /* position: relative; */
            width:clamp(260px, 30vw, 700px);
            background-color: var(--secondary);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 3px 3px 8px #444;
            text-align: center;
            font-size: clamp(1rem, 1.7vw, 3rem);
            
        }
        #alert > div > button{
            font-size: 23px;
            padding: 8px 10px;
            border-radius: 4px;
            border: none;
            margin-block: 1rem;
            color: var(--secondary);
            cursor: pointer;
        }
        #alert > div > button:active{
            scale: .98;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <section id="alert">
        <div>
            <p>Something went wrong, please try Again</p>
            <button id="refresh-btn">
                Refresh
            </button>
        </div>
    </section>
    <section class="modal">
        <div>
            <button id="close-btn">
                x
            </button>
            <form action="../validation page/validate_bar_balance.php" method="POST" id="action-form">
                <span id="sign">+</span><input type="number" name="amount" id="amount" placeholder="Enter amount">
                <input type="number" name="action" id="action">
                <input type="submit" value="procced" name="update">
            </form>
        </div>
    </section>
    <header>
        <h1>Dashboard</h1>
    </header>
    <main>
        <section class="side-bar"> 
            <div id="name-icon" class="datas"  data-text="<?php echo strtoupper($user["username"][0])?>">
            </div>
            <p><?php echo $user["username"]?></p>
            <a href="../index.php">Log-out</a>
        </section>
        <section id="balance-area"> 
            <div>
                <p>Balance: </p>
                <p id="balance" data-text="<?php echo $balance ?>" class="datas"></p>
            </div>
            <button id="add-btn">-</button>
            <button id="get-btn">+</button>
        </section>
    </main>

    <script>
        const addBtn = document.querySelector("#add-btn");
        const getBtn = document.querySelector("#get-btn");
        const modal = document.querySelector(".modal");
        const closeBtn = document.querySelector("#close-btn");
        const sign = document.querySelector("#sign");
        const actionForm = document.querySelector("#action-form");
        const amountInput = document.querySelector("#action-form > input[type=number]");
        const action = document.querySelector('#action');
        const alert = document.querySelector("#alert");
        const refBtn = document.querySelector("#refresh-btn");

        alert.style.display = "<?php echo $error ? "flex" : "none" ?>";

        // modal operation
        const openModal = (act) => {
            const oper = act.target.textContent;
            sign.textContent = oper;
            action.value = oper === "-" ? 0 : 1;
            modal.style.display = "flex";
        }
        
        const closeModal = () => {
            modal.style.display = "none";
        };   

        actionForm.addEventListener("submit", (ev) => {
            if(amountInput.value === ""){
                ev.preventDefault();
            }
        })

        refBtn.addEventListener("click", ()=> location.reload()); 
        closeBtn.addEventListener("click", closeModal)
        addBtn.addEventListener("click",openModal);
        getBtn.addEventListener("click",openModal);
    </script>
</body>
</html>