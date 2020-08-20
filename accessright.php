<?php  /*1904362*/

function isAdmin(){
    if(array_key_exists("loggedin", $_SESSION) && $_SESSION['loggedin'] == TRUE && $_SESSION['admin'] == 1) {
        return true;
    }
    return false;
}

function isLoggedIn(){
    if(array_key_exists("loggedin", $_SESSION) && $_SESSION['loggedin'] == TRUE) {
        return true;
    }
    return false;
}
$url = $_SERVER['REQUEST_URI'];

if(isLoggedIn()){
    switch($url){
        case "login.php":
            header("Location: index.php");
        case "register.php":
            header("Location: index.php");
    }
}


?>