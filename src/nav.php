<nav class = "navbar"> 
   <ul class="ulElementNavbar">
        <div class="navbarmain">
        <li class="listElementNavBar"><a class="a" href="index.php">Home</a></li>
        <li class="listElementNavBar"><a class="a" href="bookmark.php">Bookmarks</a></li>
        <?php if(isLoggedIn()){
            echo "<li class=\"listElementNavBar\"><a class=\"a\" href=\"/ce154/userprofile.php?supportticket=\">Contact us</a></li>";
        } else{
            echo "<li class=\"listElementNavBar\"><a class=\"a\" href=\"/ce154/login.php\">Contact us</a></li>";
           
        }
            ?>
        <li class="listElementNavBar"><a class="a" href="careers.php">Careers</a></li>    
        </div>
            <div class="navbarbutton">
            <?php if(isLoggedIn()){
       
            echo "<li class=\"listElementNavBar\"><a class=\"log\" href=\"userprofile.php\">".$_SESSION['username']."</a>";
        } else{
          
            echo "<li class=\"listElementNavBar\"><a class=\"log\" href=\"login.php\">Login</a></li>";
        }
            ?></div>
      
    </ul>
    

   </nav>