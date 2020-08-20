<!-- /*1904362*/ -->
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="assets/stylesheets/loginStyleSheet.css" type = "text/css">
<?php 
$pagetitle = "User Profile";
include("header.php"); 
if(!isLoggedIn()){
    header("Location: login.php");
}
?>
</head>
<body> 
<div class="logInContainer">
    <div class="optionholder">   
        <div class="logInForm" style="background-color: #084281;"> 
        <form method="get" action="userprofile.php">
        <?php echo "<p class=\"usernametext\">".$_SESSION['username']."'s profile</p>" ?> 
        <button type="submit" name="supportticket"> Send a Support Ticket</button>
        <button type="submit" name="viewsupport"> View your support tickets</button>
        
        <?php if(isAdmin()){ ?>
        <button type="submit" name="makeadmin"> User access rights</button>    
        <button type="submit" name="creategame"> Add game to library</button>
        <button type="submit" name="addjob">Advertise new job</button>

        <?php } ?>
        <button type="submit" name="logout"> Logout</button>
        </form>
        <?php 
        if(isset($_GET['logout'])){
            logout();
        }
        ?>
        </div> 
         
         <?php
                if(isset($_GET['viewsupport'])){
                    ?>
                    <div class="logInForm" style="overflow: scroll;"> 
                    <form method="post" action="/ce154/userprofile.php?viewsupport=">
                    <p class="err">
                    <?php 
                         viewtickets(connect());
                       ?></p>
                    <br>
                </form></div> <?php } ?>
            <?php
                if(isset($_GET['supportticket'])){
                    ?>
                    <div class="logInForm"> 
                    <form method="post" action="/ce154/userprofile.php?supportticket=">
                    <p class="err"><?php 
                    if(isset($_POST['sendticket'])){ 
                        newticketvalidation();
                    } else {
                        echo "<br>";
                    } ?></p>
                    <br>
                    <label>E-mail address:</label>
                    <input type="text" name="email">
                    <label>Subject:</label>
                    <input type="text" name="subject">
                    <label>Message:</label>
                    <input type="text" name="message" class="inputlarge">
                    <button name="sendticket" type="submit">Send ticket</button>
                </form></div> <?php
                }

                if(isset($_GET['creategame'])){
                    if(isAdmin()){?>
                    <div class="logInForm"> 
                    <form method="post" action="/ce154/userprofile.php?creategame=">
                    <p class="err"><?php 
                    if(isset($_POST['addgame'])){ 
                        newgamevalidate();
                    } else {
                        echo "<br>";
                    } ?></p>
                    <br>
                    <label>Enter game title</label>
                    <input type="text" name="title">
                    <label>Add 5 images separated by space (links)</label>
                    <input type="text" name="image">
                    <label>Enter the game's genre</label>
                    <input type="text" name="genre">
                    <label>Enter the game's rating</label>
                    <input type="text" name="rating">
                    <label>Enter the game's description</label>
                    <input type="text" name="desc">
                    <button name="addgame" type="submit">Add game</button>
                    </form></div> <?php
                } else{
                    echo "<p class=\"err\" style=\"color:red;\">Only admins can add game!";
                }}

                if(isset($_GET['addjob'])){
                    if(isAdmin()){?>
                    <div class="logInForm"> 
                    <form method="post" action="/ce154/userprofile.php?addjob=">
                    <p class="err"><?php 
                    if(isset($_POST['sendapplication'])){ 
                        jobvalidation();
                    } else {
                        echo "<br>";
                    } ?></p>
                    <br>
                    <label>Enter Job Title</label>
                    <input type="text" name="jobtitle">
                    <label>Job Salary: </label>
                    <input type="text" name="salary">
                    <label>Job Description</label>
                    <input style="height:100px" type="text" name="jobdescription">
            
                    <button name="sendapplication" type="submit">Advertise job</button>
                    </form></div> <?php
                } else{
                    echo "<p class=\"err\" style=\"color:red;\">Only admins can add jobs!";
                }}

                if(isset($_GET['makeadmin'])){
                    ?>
                    <div class="logInForm"> 
                    <form method="post" action="/ce154/userprofile.php?makeadmin=">
                    <?php
                    if(!userSpan(connect())) {
                        echo "<p class=\"err\" style=\"color:red\"> There are no users to display.</p>";
                    }
                    if(isset($_POST['giveadmin'])){ 
                        if(!makeAdmin(connect())){
                            echo "<p style=\"color:red\"><strong>Task failed!</strong></p>";
                        } else{
                            echo "<meta http-equiv='refresh' content='0'>";
                            echo "<p style=\"color:red\"><strong>Done!</strong></p>";
                        }
                    } else {
                        echo "<br>";
                    } ?>
                </form></div> <?php
                }
            ?>
            
        
        </div>
    </div>
</div>
<?php
include("footer.php");
?>
</body>
</html>