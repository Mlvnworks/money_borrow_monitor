<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>
<body>
    <main id="main-section" class="main-signup">
        <form action="../validation page/validate_signup.php" method="post" id="login-form">
            <label for="first-name">First name</label>
            <input type="text" name="first-name" id="first-name" placeholder="Set First name..." required>

            <label for="last-name">Last name</label>
            <input type="text" name="last-name" id="last-name" placeholder="Set Last name..." required>
            
            <label for="age">Age</label>
            <input type="text" name="age" id="age" placeholder="Set Age..." required>

            <label for="username" >Username</label>
            <input type="text" name="username" id="username" placeholder="Set Username..." required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Set Password..."required>

            <label for="phone">Phone</label>
            <input type="number" name="phone" id="phone" placeholder="Set Phone..." required>

            <input type="submit" value="Sign-up" name="sign-up">
        </form>
        <section id="sign-up-section">
            <div class="divider">
                <hr>
                OR
                <hr>
            </div>
           <a href="../index.php">Log-in</a>
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