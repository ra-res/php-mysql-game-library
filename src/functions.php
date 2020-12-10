<?php
function gameListContent2($link, $name, $genre){
   
    if ($name == null && $genre == null){
		
      $result = mysqli_query($link, "SELECT * from games;");
      while($row = mysqli_fetch_assoc($result)){
             echo "<div class=\"gameList\"> <img src=".$row['image']." class=\"mainGameImage\"><button value=\"".$row['id']."\" class=\"gamename\" name=\"gameid\"><strong>".$row["title"]."</strong></button></div>"; 
   }
   } elseif ($name != null && $genre == null) {
      $stmt = $link->prepare("select * from games where title like ?;");

      if ( !$stmt ) {
         die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
      }
      $temp = stringCheck($name, "sql");
      $param = "%".$temp."%";
      $stmt->bind_param("s", $param);
   
      if ( !$stmt->execute() ) {
         die("couldn't execute statement");
     }
      
      $result = $stmt->get_result();

      while($row = $result->fetch_assoc()){
         echo "<div class=\"gameList\"> <img src=".$row['image']." class=\"mainGameImage\"><button value=\"".$row['id']."\" class=\"gamename\" name=\"gameid\"><strong>".$row["title"]."</strong></button></div>"; 
      }
   
   } elseif ($name == null && $genre != null) {
      $stmt = $link->prepare("select * from games where genre like ?");
      if ( !$stmt ) {
         die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
      }
      $temp = stringCheck($genre, "sql");
      $param = "%".$temp."%";
      $stmt->bind_param("s", $param);
 
      if ( !$stmt->execute() ) {
         die("couldn't execute statement");
     }
      
      $result = $stmt->get_result();

      while($row = $result->fetch_assoc()){
         echo "<div class=\"gameList\"> <img src=".$row['image']." class=\"mainGameImage\"><button value=\"".$row['id']."\" class=\"gamename\" name=\"gameid\"><strong>".$row["title"]."</strong></button></div>";; 
      }
	  
   } elseif ($name != null && $genre != null) {
      $stmt = $link->prepare("select * from games where title like ? or genre like ?;");
      if ( !$stmt ) {
         die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
      }
      $temp1 = stringCheck($name, "sql");
      $temp2 = stringCheck($genre, "sql");
      $param1 = "%".$temp1."%";
      $param2 = "%".$temp2."%";
      $stmt->bind_param("ss", $param1, $param2);

      if ( !$stmt->execute() ) {
         die("couldn't execute statement");
     } 

      $result = $stmt->get_result();

      while($row = $result->fetch_assoc()){
         echo "<div class=\"gameList\"> <img src=".$row['image']." class=\"mainGameImage\"><button value=\"".$row['id']."\" class=\"gamename\" name=\"gameid\"><strong>".$row["title"]."</strong></button></div>"; 
      }
   }
  
   }

  


function gameListContent($link){
   $query = "select * from games";
   $result = mysqli_query($link, $query);
   $data = [];
   while($row = mysqli_fetch_assoc($result)){
      $data[$row['id']] = $row; 
   }
   return $data;
}

function genretable($link){
   $query = "select * from genres";
   $result = mysqli_query($link, $query);
   $data = [];
   while($row = mysqli_fetch_assoc($result)){
      $data[] = $row; 
   }
   return $data;
}

function getImage($link, $gameID, $imgNo){
      $query = "select id, image from games";
      $result = mysqli_query($link, $query);
      if (!$result){
         return false;
      }
      $arr;
      while($row = mysqli_fetch_assoc($result)){ 
         $r = $row['id'];
         $string = $row['image'];
         $arr[$r] = explode(" " ,$string);
      }
      return $arr[$gameID][$imgNo];
}     


function checkBoxSpan(){
   $genreList = array();
   $gamesdata = gameListContent(connect());
   $genredata = genretable(connect());
   foreach($genredata as $i){
         $genreList[$i['id']] = $i['title']; 
      }
   echo "<p><em> Filter by genre: </em></p>";
   foreach($genreList as $k=>$v){
         echo "<label class=\"container\">".$v."
               <input type= \"radio\" name=\"genreSelected\" value=".$k.">
               <span class=\"checkmark\"></span>
            </label> <br>"; 
   }  
}
function stringCheck($var, $type){
        switch($type) {
                case 'html':
                        $safe = htmlspecialchars($var);
                        break;
                case 'sql':
                        $safe = mysqli_real_escape_string(connect(), $var);
                        break;
                case 'uname':
                        if(preg_match('/[^a-zA-Z0-9_]/', $var) == 0){
                            return true;
                         }
                            return false;  
                case 'number':
                        if(preg_match('/[^0-9_]/', $var) == 0){
                            return true;
                         }
                            return false;  
                case 'email': 
                        if (filter_var($var, FILTER_VALIDATE_EMAIL)) {
                            return true;
                        }
                        return false;   
                case 'url':
                        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$var)) {
                            return true;
                        } 
                        return false;      
                case 'tags':
                        $tagStr= "";
                        $pat_str= array("/(<\s*\b({$tagStr})\b[^>]*>)/i", "/(<\/\s*\b({$tagStr})\b\s*>)/i");
                        $safe = preg_replace($pat_str, "", $var); 
                        break;    
                default:
                        $safe = htmlspecialchars($var);
        }
        return $safe;
}


function logIn(){
   if(empty($_POST['username']))
   {
       echo "Username is missing";
       return false;
   }elseif (empty($_POST['password']))
   {
       echo "Password is missing";
       return false;
   } else{ 
   $username = trim($_POST['username']);
   $password = trim($_POST['password']);
   
   } 
   if(!DBCheck(connect(), $username, $password)){
       return false;
   }
   
   $_SESSION['username'] = $username;
   $_SESSION['password'] = $password;
   $_SESSION['loggedin'] = true;
   header("Location: index.php");

}

function DBCheck($link, $username, $password){
   $uname = stringCheck($username,"sql");
   $pass = stringCheck($password,"sql");
   $stmt = $link->prepare("select * from users where uname = ?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
       return false;
   }
   $stmt->bind_param("s", $uname);
   if ( !$stmt->execute() ) {
      die("couldn't execute");
   return false;
   }
   $result = $stmt->get_result();


   if ($result->num_rows != 1){
      return false;
   }
   
   while($res = $result->fetch_assoc()){
      if(sha1($pass.$res["salt"]) != $res["pass"]){
         echo "Username and password did not match!";
         return false;
      } else{
         $_SESSION['admin'] = $res['is_admin'];
      }
     
   }
   return true; 
}


function unameCheck($link){
   $uname = $_POST['unameinput'];
   $stmt = $link->prepare("select * from users where uname = ?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
       return false;
   }
   $stmt->bind_param("s", $uname);
   if ( !$stmt->execute() ) {
      die("couldn't execute");
   return false;
   }
   $result = $stmt->get_result();


   if ($result->num_rows == 1){
      return false;
   }
   
   while($res = $result->fetch_assoc()){
      if($res['uname'] == $uname){
         return false;
      }}
   return true; 
}



function registerValidation(){
   if(!isset($_POST['tc'])){
      echo "Please agree to the terms and conditions!";
      return false;
   }if(empty($_POST['unameinput'])){
       echo "Username is missing";
       return false;
   }elseif (empty($_POST['passwordinput'])){
       echo "Password is missing";
       return false; 
   }elseif (!stringCheck($_POST['unameinput'], "uname")){
      echo "Username can only contain letters or numbers";
      return false;
   }elseif (strlen($_POST['unameinput'])<3){
       echo "Username must contain at least 3 characters";
      return false;
   }elseif (strlen($_POST['passwordinput'])<6){
      echo "Password must contain at least 6 characters";
      return false;
   }elseif (!unameCheck(connect())){
      echo "This username is already taken!";
      return false;
   }
   $username = trim($_POST['unameinput']);
   $password = trim($_POST['passwordinput']);
  
   if(!createAccount(connect(), $username, $password)){
      return false;
  }
 
  $_SESSION['username'] = $username;
  $_SESSION['password'] = $password;
  $_SESSION['loggedin'] = true;
  $_SESSION['admin'] = 0;
  header("Location: userprofile.php");
}

function createAccount($link, $username, $password){
   $username = stringCheck($username, "html");
   $username = stringCheck($username, "sql");
   $password = stringCheck($password, "html");
   $password = stringCheck($password, "sql");
   $username = stringCheck($username, "tags");
   $salt = uniqid();
   $password .= $salt;
   $password = sha1($password);
   $stmt = $link->prepare("INSERT INTO users VALUES (null, ?, ?, ?, 0);");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
       return false;
   }
   
   $stmt->bind_param("sss", $username, $password, $salt);
   if ( !$stmt->execute() ) {
      die("couldn't execute");
      return false;
   }
   return true;
}

function logout(){         
   session_destroy();
   header("Location: index.php");
}

function newgamevalidate(){
   if(empty($_POST["title"])){
      echo "Please enter the title";
      return false;
   } if(empty($_POST["image"])){
      echo "Please enter an image";
      return false;
   } if(!stringCheck($_POST['image'], "url")){
      echo "Please enter a valid URL in the image field";
      return false;
   } if(empty($_POST["genre"])){
         echo "Please enter a genre";
         return false;
   }if(empty($_POST["rating"])){
      echo "Please enter the rating";
      return false;
   }if(empty($_POST["desc"])){
      echo "Please enter the description";
      return false;
   } if(!stringCheck($_POST["rating"], "number")){
      echo "Rating must be a number from 0-100";
      return false;
   } if($_POST['rating'] > 100 || $_POST['rating'] < 0){
      echo "Rating must be a number from 0-100";
      return false;
   }if(!genreCheck(connect(), $_POST["genre"])){   
      echo "Genre doesn't exist and system failed to create a new one!";
      return false;  
   }if(!insertgame(connect())){
      return false;
   }
   echo "Game successfully added!";
   return true;
   }


function insertgame($link){
   $title = $_POST['title'];
   $image = $_POST['image'];
   $genre = $_POST['genre'];
   $rating = $_POST['rating'];
   $desc = $_POST['desc'];
   $title = stringCheck($title, "sql");
   $image = stringCheck($image, "sql");
   $genre = stringCheck($genre, "sql");
   $rating = stringCheck($rating, "sql");
   $desc = stringCheck($desc, "sql");
   $title = stringCheck($title, "tags");
   $desc = stringCheck($desc, "tags");

   $id = null;

   $stmt = $link->prepare("insert into games values (?,?,?,?,?,?)");
   if ( !$stmt ) {
       deleteonfailure(connect());
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ssssis", $id, $title, $image, $genre, $rating, $desc);

   if ( !$result ) {
      deleteonfailure(connect());
       return false;
   }

   if ( !$stmt->execute() ) {
      deleteonfailure(connect());
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   return true;

}

function genrecheck($link, $genre){
   $result = mysqli_query($link, "SELECT * from genres;");
   while($row = mysqli_fetch_assoc($result)){
      if($genre == $row['title'] || $genre == $row['id']){
         return true;
      }
   }
   if(!genrecreate($link,$genre)){
      echo "Failed to add game!";
      return false;
   } 
   return true;
            
}

function genrecreate($link, $genre){
   $genre = stringCheck($genre, "sql");
   $len = strlen($genre);
   if($len<=3){
      $id = strtolower($genre);
   } else {
      $tempid = substr($genre,0,3);
      $id = strtolower($tempid);
   }
   $stmt = $link->prepare("insert into genres values (?,?)");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ss", $id, $genre);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      return false;
   }
   return true;
}

function deleteonfailure($link){
   $id=$_POST['genre'];
   $title = $_POST['genre'];
   $stmt = $link->prepare("DELETE FROM genres WHERE id=? OR title=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ss", $id, $title);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      return false;
   }
   return true;
}


function insertmessage($link){
   if(!isLoggedIn()){
      echo "Please log in to send a message";
      return false;
   }
   
   $uname = $_SESSION['username'];
   if (!userid(connect(), $uname)){
      return false;
   } else {
   $uid = userid(connect(), $uname);
   }
   $email = $_POST['email'];
   $subject = $_POST['subject'];
   $message = $_POST['message'];
   $email = stringCheck($email, "sql");
   $subject = stringCheck($subject, "sql");
   $message = stringCheck($message, "sql");
   $subject = stringCheck($subject, "tags");
   $message = stringCheck($message, "tags");
   $subject = stringCheck($subject, "html");
   $message = stringCheck($message, "html");
   $id = null;
   

   $stmt = $link->prepare("insert into supportticket values (?,?,?,?,?)");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("issss", $id, $uid, $email, $subject, $message);
   
   if ( !$result ) {
       echo "be";
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   return true;

}

function userid($link, $uname){
   $stmt = $link->prepare("select id from users where uname = ?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("s", $uname);
   if ( !$result ) {
       return false;
   }
   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   $res = $stmt->get_result();
   $data = "";
   while($row = mysqli_fetch_assoc($res)){
      $data = $row['id']; 
   }
   return $data;
}

function newticketvalidation(){
   if(empty($_POST["email"])){
      echo "Please enter email address";
      return false;
   } if(!stringCheck($_POST['email'], "email")){
      echo "Please enter a valid e-mail address";
      return false;
   } if(empty($_POST["subject"])){
      echo "Please enter a subject";
      return false;
   } if(!stringCheck($_POST['subject'], "uname")){
      echo "The subject must not contain any special characters";
      return false;
   } if(empty($_POST["message"])){
         echo "Please enter a message";
         return false;
   } if(!insertmessage(connect())){
         return false;
   }
   echo "Ticket has been sent!";
   return true;
   }

function viewtickets($link){
   $uid = userid(connect(), $_SESSION['username']);
   $stmt = $link->prepare("select * from supportticket where unameid = ?");
   if ( !$stmt ) {
         die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("s", $uid);
   if ( !$result ) {
         return false;
   }
   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   $res = $stmt->get_result();
   if(mysqli_num_rows($res)==0){
      echo "You have not sent any support tickets.";
      return false;
   }
   while($row = mysqli_fetch_assoc($res)){
      echo "<strong>Ticket number:</strong>  ".$row['id']."<br>"."<strong>Ticket Subject</strong>:    ".$row['subject']."<br> <strong>Message</strong>:   ".$row['message']."<br><br>"; 
   }
}

function bookmarkexists($link, $gameid, $username){
   if(!userid(connect(), $username)){
      return false;
   }
   $uid=userid(connect(), $username);

   $stmt = $link->prepare("select * from bookmarks where user_id=? AND game_id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ii", $uid, $gameid);
   if ( !$result ) {
       return false;
   }
   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   $res = $stmt->get_result();
   if(mysqli_num_rows($res)==1){
      return true;
   }
   return false;
}

function createbookmark($link, $gameid, $username){
   if(!userid(connect(), $username)){
      return false;
   }
   $uid=userid(connect(), $username);
  
    $stmt = $link->prepare("insert into bookmarks values (?,?)");
    if ( !$stmt ) {
        return false;
    }

    $result = $stmt->bind_param("ii", $uid, $gameid);
    if ( !$result ) {
        return false;
    }

    if ( !$stmt->execute() ) {
        die("couldn't execute statement");
        return false;
    }
    return true;

}

function removebookmark($link, $gameid, $username){
   if(!userid(connect(), $username)){
      return false;
   }
   $uid=userid(connect(), $username);
  
    $stmt = $link->prepare("DELETE FROM bookmarks WHERE user_id=? AND game_id=?");
    if ( !$stmt ) {
        return false;
    }

    $result = $stmt->bind_param("ii", $uid, $gameid);
    if ( !$result ) {
        return false;
    }

    if ( !$stmt->execute() ) {
        return false;
    }
    return true;
}

function newreviewvalidation(){
   if(empty($_POST["review"])){
      echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Please write a review before submitting!</strong></p>";
      return false;
   } if(empty($_POST["newrating"])){
      echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Please enter a rating</strong></p>";
      return false;
   } if(empty($_POST["reviewtitle"])){
         echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Please enter a title!</strong></p>";
         return false;
   } if($_POST['newrating']>100 || $_POST['newrating']<0){
      echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Rating must be between 0-100</strong></p>";
      return false;  
   } if(hasreview(connect())){
         if(updatereview(connect())){
            echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Your review has been updated</strong></p>";
            return true;       
         }
   } if(!insertreview(connect())){
         return false;
   }
   echo "<p class=\"err\" style=\"color:red; margin-left: 2%;\"><strong>Review has been submitted</strong></p>";
   return true;
}

function insertreview($link){
   if(!userid(connect(), $_SESSION['username'])){
      return false;
   }
   $uid=userid(connect(), $_SESSION['username']);
   $gameid= $_GET['gameid'];
   $rating = $_POST['newrating'];
   $title = $_POST['reviewtitle'];
   $review = $_POST['review'];
   $id = null;

   $rating = stringCheck($rating, "sql");
   $title = stringCheck($title, "sql");
   $review = stringCheck($review, "sql");
   $rating = stringCheck($rating, "tags");
   $title = stringCheck($title, "tags");
   $review = stringCheck($review, "tags");
   $rating = stringCheck($rating, "html");
   $title = stringCheck($title, "html");
   $review = stringCheck($review, "html");
   $stmt = $link->prepare("insert into reviews values (?,?,?,?,?,?)");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("iiiiss", $id, $uid, $gameid, $rating, $title, $review);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   updaterating(connect());
 
   return true;

}

function updaterating($link){ #in game's table
   $data = gameListContent($link);
   $newrating=0;
   foreach($data as $k=>$v){
      if($v['id'] == $_GET['gameid']){
         if($v['rating'] == 0){
               $newrating = $_POST['newrating'];  
      } else{
         $newrating = ($v['rating']*0.9) + ($_POST['newrating']*0.1);
      }
   }
}
   if($newrating == 0){
      return false;
   }
   $gameid = $_GET['gameid'];
   $stmt = $link->prepare("UPDATE games SET rating=? WHERE id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ii", $newrating, $gameid);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   return true;
}

function hasreview($link){
   if(!userid(connect(), $_SESSION['username'])){
      return false;
   }
   $uid=userid(connect(), $_SESSION['username']);
   $gameid = $_GET['gameid'];
   $stmt = $link->prepare("select * from reviews where user_id=? AND game_id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("ii", $uid, $gameid);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   $res = $stmt->get_result();
   if(mysqli_num_rows($res)>=1){
      return true;
   }
   return false;

}

function updatereview($link){
   if(!userid(connect(), $_SESSION['username'])){
      return false;
   }
   $uid=userid(connect(), $_SESSION['username']);
   $gameid= $_GET['gameid'];
   $rating = $_POST['newrating'];
   $title = $_POST['reviewtitle'];
   $review = $_POST['review'];
   $id = null;

   $rating = stringCheck($rating, "sql");
   $title = stringCheck($title, "sql");
   $review = stringCheck($review, "sql");
   $rating = stringCheck($rating, "tags");
   $title = stringCheck($title, "tags");
   $review = stringCheck($review, "tags");
   $rating = stringCheck($rating, "html");
   $title = stringCheck($title, "html");
   $review = stringCheck($review, "html");
   $stmt = $link->prepare("UPDATE reviews SET rating=?,title=?, review=? WHERE user_id=? AND game_id=?");
   if ( !$stmt ) {
       return false;
   }
   $result = $stmt->bind_param("issii", $rating, $title, $review, $uid, $gameid);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   updaterating(connect());
   return true;
}

function reviewspan($link){ 
   $gameid = $_GET['gameid'];
   $stmt = $link->prepare("select * from reviews where game_id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("i", $gameid);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   $res = $stmt->get_result();
   if(mysqli_num_rows($res)==0){
      return false;
   }
   echo "<div style=\"display:flex; justify-content:center; width:100%;\"><p style=\"color:white; font-size:25px;margin-right:20%;\"><strong>All Reviews:<strong></p></div>";
   while($row = $res->fetch_assoc()){
      echo "<div style=\"border-bottom: 1px #40c4ff solid;width:87%; display:flex; flex-direction: column;\">";
      echo "<p style=\"color:white;\"><em>Author:   </em></label>".username(connect(), $row['user_id'])."</p>" ;
      echo "<p style=\"color:white;\"><em>Review title:   </em></label>".$row['title']."</p>" ;
      echo "<p style=\"color:white;\"><em>Rating:   </em></label>".$row['rating']."</p>";
      echo "<p style=\"color:white;\"><em>Message:   </em></label>".$row['review']."</p>";
      echo "</div>";
   }
   return true;
}

function username($link, $uid){
   $stmt = $link->prepare("select uname from users where id = ?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("i", $uid);
   if ( !$result ) {
       return false;
   }
   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   $res = $stmt->get_result();
   $data = "";
   while($row = mysqli_fetch_assoc($res)){
      $data = $row['uname']; 
   }
   return $data;
}

function userSpan($link){
   $stmt = $link->prepare("select * from users where is_admin = 0");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
       return false;
   }
   if ( !$stmt->execute() ) {
      die("couldn't execute");
      return false;
   }
   $result = $stmt->get_result();


   if ($result->num_rows == 0){
      return false;
   }
   echo "<div style=\" display:flex; flex-direction:column; overflow: scroll; width: 370px; height: 500px;\">";
   while($res = $result->fetch_assoc()){
      echo "<p style=\"color:white;\"> User ID: ".$res['id']."  Username: ".$res['uname']."</p><button style=\"width:150px; height:60px; margin-top:2%;\" name=\"giveadmin\" value=".$res['id']."> ^MAKE ADMIN^ </button>";
   }
   echo "</div>";
   return true; 

}

function makeAdmin($link){
   if(!isAdmin()){
      echo "<p style=\"color:red;\">Only privileged users can do this!</p>";
      return false;
   }
   $uid = $_POST['giveadmin'];
   $stmt = $link->prepare("UPDATE users SET is_admin=1 WHERE id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
   }
   $result = $stmt->bind_param("i", $uid);
   
   if ( !$result ) {
       return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   return true;
}


function getbookmarks($link){
   if(!userid(connect(), $_SESSION['username'])){
      return false;
   }
   $uid=userid(connect(), $_SESSION['username']);
   $gameid = array();
   $stmt = $link->prepare("select * from bookmarks where user_id=?");
   if ( !$stmt ) {
       die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
       return false;
   }
   $result = $stmt->bind_param("i", $uid);

   if ( !$stmt->execute() ) {
      die("couldn't execute");
      return false;
   }
   $result = $stmt->get_result();

   if ($result->num_rows == 0){
      return false;
   }
   while($res = $result->fetch_assoc()){
      $gameid[] = $res;
   }
   return $gameid;
}

function getjobs($link){
   $jobs = array();
   $result = mysqli_query($link, "SELECT * from jobs;");

   if ($result->num_rows == 0){
      return false;
   }
   while($res = $result->fetch_assoc()){
      $jobs[] = $res;
   }
   return $jobs;
}

function applicationvalidation($link){
   if(empty($_POST["user_firstname"])){
      echo "Please enter your First Name";
      return false;
   }if(empty($_POST["user_lastname"])){
      echo "Please enter your Last Name";
      return false;
   }if(empty($_POST["user_mail"])){
      echo "Please enter your email address";
      return false;
   }if(empty($_POST["user_phone"])){
      echo "Please enter your phone number";
      return false;
   }if(!is_numeric($_POST['user_phone'])){
      echo "Phone number must be a number";    
      return false;  
   }
   if(floor(log10($_POST['user_phone']) + 2)!=11){
      echo "Please enter a valid phone number";
      return false;  
   }if(empty($_POST["user_why"])){
      echo "Please specify why you would want to work for us";
      return false;
   }if(!submitapplication(connect())){
      echo "Failed to submit application! Try again!";
      return false;
   }
   echo "Application has been submitted";
   return true;
}

function submitapplication($link){
   $applicationid = null;
   $jobname = $_GET['jobapply'];
   $fname= $_POST['user_firstname'];
   $lname = $_POST['user_lastname'];
   $email = $_POST['user_mail'];
   $whyus = $_POST['user_why'];
   $phoneno = $_POST['user_phone'];
   
   $fname = stringCheck($fname, "sql");
   $lname = stringCheck($lname, "sql");
   $whyus = stringCheck($whyus, "sql");
   $fname = stringCheck($fname, "tags");
   $lname = stringCheck($lname, "tags");
   $whyus = stringCheck($whyus, "tags");
   $fname = stringCheck($fname, "html");
   $lname = stringCheck($lname, "html");
   $whyus = stringCheck($whyus, "html");

   $stmt = $link->prepare("INSERT INTO jobapplications VALUES(?,?,?,?,?,?,?)");
   if ( !$stmt ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   $result = $stmt->bind_param("sssssis", $applicationid, $jobname, $fname, $lname, $email, $phoneno, $whyus);
   
   if ( !$result ) {
      return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   return true;
}

function jobvalidation(){
   if(empty($_POST["jobtitle"])){
      echo "Please enter job title";
      return false;
   }if(empty($_POST["salary"])){
      echo "Please enter salary";
      return false;
   }if(!stringCheck($_POST['salary'], "number")){
      echo "Salary must be a numerical value!";
      return false;   
   }if(empty($_POST["jobdescription"])){
      echo "Please enter job's description";
      return false;
   }if(!addjob(connect())){
      echo "Failed to add job! Try again!";
      return false;
   }
   echo "Job has been added";
   return true;
}

function addjob($link){
   $jobid = null;
   $jobname = $_POST['jobtitle'];
   $salary= $_POST['salary'];
   $desc = $_POST['jobdescription'];

   
   $jobname = stringCheck($jobname, "sql");
   $salary = stringCheck($salary, "sql");
   $desc = stringCheck($desc, "sql");
   $jobname = stringCheck($jobname, "tags");
   $salary = stringCheck($salary, "tags");
   $desc = stringCheck($desc, "tags");
   $jobname = stringCheck($jobname, "html");
   $salary = stringCheck($salary, "html");
   $desc = stringCheck($desc, "html");

   $stmt = $link->prepare("INSERT INTO jobs VALUES(?,?,?,?)");
   if ( !$stmt ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }
   $result = $stmt->bind_param("ssss", $jobid, $jobname, $salary, $desc);
   
   if ( !$result ) {
      return false;
   }

   if ( !$stmt->execute() ) {
      echo "could not execute could not prepare statement: " . $link->errno . ", error: " . $link->error;
      return false;
   }

   return true;
}

?>


