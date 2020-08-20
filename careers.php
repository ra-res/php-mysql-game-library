<!-- /*1904362*/ -->
<!DOCTYPE HTML>
<html>
    <head>
        <?php 
        $pagetitle = "Careers";
        include("header.php");
        
        ?>
    </head>
    <body>
        <div class="headerdiv" style="background-image: url(assets/images/careersbackground.jpg)"><div class="layer" style="display:flex; flex-direction:row; justify-content:center;">  <?php 
                    echo "<h1 style=\"color:white; margin-top:15%; font-size:45px\">Welcome to our careers page!</h1>";?></div> 
             </div>
             <main class ="mainContainer">
                <div class="gameContainer">
                    <form method="GET" action="jobapplication.php">
                    <?php 
                    
                    $jobs = getjobs(connect());
                    foreach($jobs as $k=>$job){
                        echo 
                            "
                            <div class=\"joblist\">
                            <div style=\"width:100%;\">
                            <p class=\"gametitle\" style=\"font-size:20px; margin-top:2%; margin-left:2%;\" >".$job['title']."</p> 
                            <label style=\"color:white; margin-left:2%;opacity:0.8;\"><em>salary: </em>£".$job['salary']."<em> per annum</em></label>
                            <p style=\"color:white; margin-left:2%;\">".$job['description']."</p>
                            <div style=\"position:absolute; position: absolute; right:0; bottom:0;\"><button value=\"".$job['title']."\" class=\"bookmark\" type=\"submit\" name=\"jobapply\"> Apply for this job</button></div>
                            </div> 
                            </div>";
                    }

                    if(isset($_GET['jobapply'])){
                        header("Location: jobapplication.php");
                    }
                    ?>
                    </form>
                </div>
            </main>   
        <?php
        include("footer.php");
        ?> 
    </body>    
</html>    