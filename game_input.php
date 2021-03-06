<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('addGame.html');
$msg = inputEmployee($dbConn, $isDevelopment);
if(!$_SESSION['isManager']) {
  menuRedirect();
}
if($_SESSION['valid']){
  echo $template->render(array('msg' => $msg, 'dno'=> $_SESSION['dno']));
} else {
  loginRedirect();
}

?>

<?php
function inputEmployee($db, $isDevelopment) {
  $uniqueInfos = gatherInfo($db, $isDevelopment);
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["game_name"];
     
     if(!checkDuplicateGname($uniqueInfos)) {//watch funtion
       $name = $_POST["game_name"];
	//$msg="Name Approved";     
     } else {
       $msg = "Duplicate Game name found";
     }
     
     $game_id = createGameID($db, $isDevelopment);//watch all post names 
	 $prize = $_POST["prize"];
     $price = $_POST["price"];
     //all inputs have been tested for correctnes with $msg	   
     
     if(!checkDuplicateGname($uniqueInfos) ){//watch funtion

       $query = "INSERT INTO game VALUES ('$prize', $price, $game_id, CURENT_TIME, '$name');";
       
       if($isDevelopment) {
         $result = pg_query($db, $query);
       } else {
         $result = $db->query($query);
       }
       if($result) {
         $msg = "Game: $name was successfully created.";
       }
     }
	 	$prize = $_POST["gamePrize"];
    $price = $_POST["gamePrice"];
    $game_id = $_POST["gameID"];
    $maint_date = $_POST["gameMaintenance"];
    $gname = $_POST["gameName"];
    $capacity = $_POST["gameCapacity"];
    $dno = $_POST["gameDepartment"];
   }
     
   return $msg;
}
?>
<?php
function gatherInfo($db, $isDevelopment) {
  $query = "SELECT gname FROM game;";//watch statement
  $data = array();
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $data[] = array('gname' => $row[0]);
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array('gname' => $row[0]);
    }
  }
  return $data;
}
?>

<?php
function createGameID($db, $isDevelopment) {
  $data = array();
  $currentId = 0;
  $query = "SELECT game_id FROM game;";//watch statement
  if($isDevelopment) {
    $results = pg_query($db, $query);
    while($row = pg_fetch_row($results)) {
      if($row[0] > $currentId) {
        $currentId = $row[0];
      }
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      if($row["game_id"] > $currentId) {
        $currentId = $row["game_id"];
      }
    }
  }
  
  $newEmpId = $currentId + 1;
  return $newEmpId;
}
?>


<?php
function checkDuplicateGname($infos) {
  $result = false;
  foreach($infos as $info) {
    $Game = $info['gname'] ?? null;
    if($Game == $_POST["game_name"]){
	    $result = true;
    } 
  }
	
  return $result;
}
?>
