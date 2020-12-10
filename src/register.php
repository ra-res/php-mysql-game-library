<!DOCTYPE HTML>
<hmtl>
    <head>
        <?php 
        $pagetitle = "Register page";
        include("header.php");
        ?>
        <link rel="stylesheet" href="assets/stylesheets/loginstylesheet.css" type = "text/css">
    </head>
    <body>
        <div class="logInContainer"> 
            <div class="logInForm"> 
                <form action="register.php" method="post"> 
                <h1 class = "formtitle">Register</h1>  
                <p class="err"><?php
                        $username = null;
                        $password = null;
                        if(isset($_POST['register'])){
                            registerValidation();
                        } else{
                            echo "<br>";
                        }

                ?> </p>
                <label  for="unameinput">Username:</label>
                <br>
                <input type="text" name="unameinput">  
                <br>
                <label  for="passwordinput">Password:</label>
                <br>
                <input type="password" name="passwordinput"> 
                <br>
                <div>
                <input style ="width:15px; margin-top:0%;" type="checkbox" name="tc" value="tc">
                <label for="tc"> I Agree to the <u><a href="termsandconditions.php"> terms and conditions </a></u></label><br>
                </div>
                   
                <button type="submit" name="register">Register +</button>
                <p class="registertext">Already have an account? <a href="login.php">Login</a></p>
                </form>
                
            </div>
        </div>
 

        <?php
        include("footer.php");
        ?>
    </body>
</html>