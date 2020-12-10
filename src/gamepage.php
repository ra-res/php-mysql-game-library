<!DOCTYPE HTML>
<html>
    <head>    
        <?php        
        $pagetitle = "Game Page";
        include("header.php"); 
        ?>  
    </head>
    <body>
    <?php 
        $allgames = gameListContent(connect());
        $thisgame = array();
        foreach($allgames as $k=>$v){
            if($v['id']==$_GET['gameid']){
                $thisgame = $v;
            }
        }
        $genretable = genretable(connect());
        $thisgenre = "";
        foreach($genretable as $k=>$v){
            if($v['id']==$thisgame['genre']){
                $thisgenre = $v;
            }
        }
        $thisrating= $thisgame['rating'];
        if($thisrating == 0){
            $thisrating = "<em>n/a</em>";
        }
            $imagepath = getImage(connect(), $_GET['gameid'], 1);
            $imagepath2 = getImage(connect(), $_GET['gameid'], 2);
            $imagepath3 = getImage(connect(), $_GET['gameid'], 3);
            $imagepath4 = getImage(connect(), $_GET['gameid'], 4); 
        ?>
        
        <main class="mainContainer">
        <div class="gamepagepicture" <?php echo "style='background-image:url(".$imagepath.") '" ?>>
		
            <div class="layer">
			
                <div class="gamepage">
                    
                    <div class="titlehold"><?php echo "<h1 class=\"gametitle\">".$thisgame['title']."</h1>".
                                                      "<p class=\"genre\"> ".$thisgenre['title']."</p>".
                                                      "<p class=\"genre\" style=\"opacity: 0.9; padding-right: 10px;\"> Current rating: ".$thisrating."
                                                      <br> 
                                                      <br>
                                                      <br>
                                                      <em>Description:</em><br>".$thisgame['description']."</p>"; 
                                                      ?>
                   
					<form method="post">
					
                    <?php if(!isLoggedIn()){
                            echo "<div> <button class=\"bookmark\" type=\"submit\" name=\"bookmarklogin\"> Login to bookmark this game</button></div>";
                    } elseif(!bookmarkexists(connect(),$_GET['gameid'], $_SESSION['username'])){
                        echo "<div> <button class=\"bookmark\" type=\"submit\" name=\"bookmarkcreate\"> Bookmark this game</button></div>";
                    } else{
                        echo "<div> <button class=\"bookmark\" type=\"submit\" name=\"bookmarkpage\"> View bookmarks page</button></div>";
                    }
                    if(isset($_POST['bookmarklogin'])){
                        header("Location: login.php");
                    }elseif(isset($_POST['bookmarkcreate'])){
                        if (createbookmark(connect(), $_GET['gameid'], $_SESSION['username'])){
                            echo "<meta http-equiv='refresh' content='0'>";
                        }else{
                            echo "Failed to create bookmark. Please try again!";
                        }    
                    }
                    elseif(isset($_POST['bookmarkpage'])){
                        header("Location: bookmark.php");
                    }
                    ?>
					
                    </form>
					
                </div>
                    
                </div>   
                 <div class="slideholder">
					
                         <div class="slide">
					
                            <?php 
                              echo "<div id=\"img1\"><img src='".$imagepath."' class=\"slideimg\"></div>"; 
                              echo "<div id=\"img2\"><img src='".$imagepath2."' class=\"slideimg\"></div>";
                              echo "<div id=\"img3\"><img src='".$imagepath3."' class=\"slideimg\"></div>";
                              echo "<div id=\"img4\"><img src='".$imagepath4."' class=\"slideimg\"></div>";
                              ?>      
							  
                          </div>
						  
                          <div style="display: flex; justify-content:center;">
						  
                          <a href="#img1" class="slidebtn">1</a>
                          <a href="#img2" class="slidebtn">2</a>
                          <a href="#img3" class="slidebtn">3</a>
                          <a href="#img4" class="slidebtn">4</a>

                         </div>
                    </div>     
					
            </div>
			
        </div>
        </main>   
        <div class="reviewcontainer"> 
                <div class="reviews">
                <div style="dislay:flex; justify-content: center; overflow:hidden;">

                <?php 
                if(isLoggedIn()){
                    if(isset($_POST['submitreview'])){
                        if(!isLoggedIn()){
                            echo "<p class=\"err\" style=\"color:red; margin-left: 5%;\"><strong>You must log in to leave a review</strong></p><br>";
                        }else{ 
                            newreviewvalidation();
                        }}else{
                        echo "<br><br>";
                    }
                     ?>
                <form method="post" class="formstyle" style="width:80%; margin-top:15%;">
                <?php 
                if(hasreview(connect())){
                    echo "<div style=\"width:80%;position: inherit;\"><p class=\"err\" style=\"color:white; margin-left: 12%;\"><strong>You already reviewed this game.</strong></p><br></div>";
                }
                ?>
                <div style="width:230px;">
                <label style="margin-left:3%;font-size:16px;color:white; margin-top:1%;margin-right:1%;"><em>Write a review title</em></label><br>
                <input style="width:40%; height:30px" class="searchboxsmall" name="reviewtitle" type="text" placeholder="">
                </div>
                <div style="width:230px">
                <label style="margin-left:3%;font-size:16px;color:white; margin-top:1%; margin-right:1%;"><em>Rate this game (0-100)</em></label><br>
                <input style="width:20%; height:30px; margin-bottom:1%" class="searchboxsmall" name="newrating" type="number" placeholder="">
                </div>
                
                <input class="reviewbox" name="review" type="text" placeholder="   Write a review">
                <input class="reviewsubmit" name="submitreview" type="submit" value="Submit" unchecked>
                  
                </form>
                <?php if(!reviewspan(connect())){ ?>
                        <div style="display:flex; flex-direction: row; justify-content:center;"><p class="err" style="color:white; margin-right:16%;"> This game doesn't have any reviews yet. </p></div>
                    <?php }}else{ ?>
                        <div style="display:flex; flex-direction: row; justify-content:center;"><p class="err" style="color:white;"> Log in to leave a review!</p></div>
                <?php     if(!reviewspan(connect())){ ?>
                        <div style="display:flex; flex-direction: row; justify-content:center;"><p class="err" style="color:white;"> This game doesn't have any reviews yet. </p></div>
                    <?php }} ?>
				</div>   
                </div> 
					
        </div>
            <?php
                 include("footer.php");
                 ?>	
    </body>
</html>