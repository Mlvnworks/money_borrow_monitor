<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Document</title>
</head>
<body>
    <?php 
        session_start();   

        $logInState = true;

        if(isset($_SESSION["loginProcess"])){
            $logInState = $_SESSION["loginProcess"];
        }
        
        echo !$logInState  ? "<div class='alert'>
                <p>Acount Doesn't Exist Or Something Went Wrong. Please Check your connection</p>
            </div>" : "";
        
        
            $_SESSION["loginProcess"] = true;
    ?>
    <main id="main-section">
        <form action="./validation page/validate_login.php" method="post" id="login-form">
            <label for="username" >Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Log-in" name="log-in">
        </form>
        <section id="sign-up-section">
            <div class="divider">
                <hr>
                OR
                <hr>
            </div>
            <a href="./pages/signup.php">Sign-up</a>
        </section>
    </main>
    <script>
        const mainSection = document.getElementById('main-section');
        const signUpSection = document.querySelector('#sign-up-section');
        const logInForm = document.querySelector('#login-form');
        const body = document.querySelector('body');


        window.addEventListener('scroll', () => {
            if(window.scrollY >= mainSection.offsetTop){
                body.style.backgroundColor = 'var(--secondary)';
                signUpSection.style.animation= 'appear 500ms forwards';
                logInForm.style.animation= 'appear 500ms forwards';
            }else{
                body.style.backgroundColor = 'var(--primary)'
            };
        })

        window.onload = () => {
            window.scrollBy(0,mainSection.offsetTop);
        }
    </script>
</body>
</html>