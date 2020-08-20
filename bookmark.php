<!-- /*1904362*/ -->
<!DOCTYPE HTML>
<html>
    <head>
        <?php 
        $pagetitle = "Bookmarks";
        include("header.php");
        
        ?>
    </head>
    <body>
        <div class="headerdiv" style="background-image: url(assets/images/bookmarksbackground.jpg)"><div class="layer" style="display:flex; flex-direction:row; justify-content:center;">  <?php 
                if(!isLoggedIn()){
                    echo "<h1 style=\"color:white; margin-top:15%;font-size:45px;\"> Please log in to bookmark a game!</h1>";
                }else{
                    echo "<h1 style=\"color:white; margin-top:15%; font-size:45px\">".$_SESSION['username']."'s bookmarks</h1>";
                }
             ?></div> 
             </div>
             <main class ="mainContainer">
                <div class="gameContainer">
                    <?php 
                    if(isLoggedIn()){
                        if(!getbookmarks(connect())){
                            echo "<h2 style=\"color:white;\"><em>No bookmarks to display</em></h2>";
                        }else{
                            $bookmarks = getbookmarks(connect());
                            $genretable = genretable(connect());
                            $games = gameListContent(connect());
                        ?> 
                        <form method="post" action="#">
                        <?php
                      
                        
                        foreach($bookmarks as $bookmark=>$b){
                            foreach($games as $game=>$g){
                                foreach($genretable as $genre=>$gnr){
                                    if($b['game_id']==$g['id'] && $gnr['id'] == $g['genre']){
                                        echo 
                                        "
                                        <div class=\"bookmarkedgame\">
                                        <div class=\"mainGameImage\"><img class=\"mainGameImage\" src=".getImage(connect(), $g['id'], 0)."></div> 
                                        <div style=\"width:100%;\">
                                        <p class=\"gametitle\" style=\"font-size:20px; margin-top:2%; margin-left:2%;\" >".$g['title']."</p> 
                                        <label style=\"color:white; margin-left:2%;opacity:0.8;\">".$gnr['title']."</label>
                                        <p style=\"color:white; margin-left:2%;\">".substr($g['description'], 0, 270)."...</p>
                                        <p style=\"color:white; margin-left:2%;\"><em>for more info visit this <a style=\"color:lightblue;\" href=\"gamepage.php?gameid=".$g['id']."\"> game's page</a></em></p>
                                        <div style=\"position:absolute; position: absolute; right:0; bottom:0;\"><button class=\"bookmark\" type=\"submit\" name=\"bookmarkremove\" value=\"".$g['id']."\"> Remove this bookmark</button></div>
                                        </div> 
                                        </div>";
                                     }
                                }
                           }
                      }
                }}
               
                    ?>  </form>
                   <?php  
                    if(isset($_POST['bookmarkremove'])){
                        $gid = $_POST['bookmarkremove'];
                        if(removebookmark(connect(), $gid, $_SESSION['username'])){
                            echo "<meta http-equiv='refresh' content='0'>";
                         }else{
                            echo "Failed to remove bookmark. Please try again!";
                }}
                    ?>
                    </form>
                </div>
            </main>   
        <?php
        include("footer.php");
        ?> 
    </body>    
</html>    