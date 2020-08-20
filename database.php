<?php /*1904362*/

$db = array();

$db['host'] = "localhost";#"cseemyweb.essex.ac.uk";
$db['user'] = "root";#"rp19791";
$db['pass'] = "";#"Xm3765DkbjY1l";
$db['name'] = "ce154";#"ce154_rp19791";


function connect(){
    global $db;
    $link = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
    if  ($link->connect_errno) {
        die("Failed to connect to MySQL: " . $link->connect_error);
    }

    return $link;
}

function get_messages($link) {
    $records = array();

    $results = $link->query("SELECT * FROM message");

    if ( !$results ) {
        return records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function save_message($link, $data) {

    $stmt = $link->prepare("insert into message(name, email, reason, message) values (?,?,?,?)");
    if ( !$stmt ) {
        die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
    }

    $result = $stmt->bind_param("ssis", $data['name'], $data['email'], $data['reason'], $data['message']);
    if ( !$result ) {
        die("could not bind params: " . $stmt->error);
    }

   
    if ( !$stmt->execute() ) {
        die("couldn't execute statement");
    }


}
