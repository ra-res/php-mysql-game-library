<!DOCTYPE HTML>
<hmtl>
    <head>
        <?php 
        $pagetitle = "Job Application";
        include("header.php");
        ?>
        <link rel="stylesheet" href="assets/stylesheets/loginstylesheet.css" type = "text/css">
    </head>
    <body>
        <div class="logInContainer"> 
            <div class="logInForm" style="height:650px"> 
                <form action="#" method="post"> 
                <h1 class = "formtitle"><?php echo $_GET['jobapply']; ?></h1>  
                <p class="err"><?php
                        if(isset($_POST['applicationsend'])){
                            applicationvalidation(connect());
                        } else{
                            echo "<br>";
                        }

                ?> </p>
                <label for="user_firstname">First Name*:</label>
                <input type="text" name="user_firstname">
                <label for="user_firstname">Last Name*:</label>
                <input type="text" name="user_lastname">
                <label for="user_mail">E-mail*:</label>
                <input type="email" name="user_mail"> 
                <label for="user_phone">Phone*:</label>
                <input type="text" name="user_phone"> 
                <label for="user_why">Why do you want to work for us?*</label>
                <input type="text" name="user_why" style="height:100px">
                <button type="submit" name="applicationsend">Send Application</button>
                </form>
                
            </div>
        </div>
 

        <?php
        include("footer.php");
        ?>  
    </body>
</html>