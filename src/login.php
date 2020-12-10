<!DOCTYPE HTML>
<hmtl>
    <head>
        <?php 
        $pagetitle = "Login Page";
        include("header.php");
        ?>
        <link rel="stylesheet" href="assets/stylesheets/loginstylesheet.css" type = "text/css">
    </head>
    <body>
        <div class="logInContainer"> 
            <div class="logInForm"> 
                <form action="login.php" method="post"> 
                <h1 class = "formtitle">Log in</h1>  
                <p class="err"><?php
                        $username = null;
                        $password = null;
                        if(isset($_POST['submit'])){
                            logIn();
                        } else{
                            echo "<br>";
                        }

                ?> </p>
                <label  for="username">Username:</label>
                <br>
                <input type="text" name="username">  
                <br>
                <label  for="password">Password:</label>
                <br>
                <input type="password" name="password" > 
                <br> 
                <br>    
                <br>
                <button type="submit" name="submit">Log in +</button>
                <p class="registertext">Don't have an account? <a href="register.php">Register</a></p>
                </form>
                
            </div>
        </div>
 

        <?php
        include("footer.php");
        ?>  
    </body>
</html>