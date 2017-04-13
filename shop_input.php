<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('addShop.html');
$msg = inputEmployee($dbConn, $isDevelopment);
echo $template->render(array('msg' => $msg, 'dno'=>$_SESSION['dno']));
?>

<?php
function inputEmployee($db, $isDevelopment) {
  $uniqueInfos = gatherInfo($db, $isDevelopment);
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["shop_name"];
     
     if(!checkDuplicateSname($uniqueInfos)) {//watch funtion
       $name = $_POST["shop_name"];
	//$msg="Name Approved";     
     } else {
       $msg = "Duplicate Shop name found";
     }
     
     $shop_id = createID($db, $isDevelopment);//watch all post names 
	 $service= $_POST["service"];
     $price = $_POST["price"];
     $dno = 2;
     //all inputs have been tested for correctnes with $msg	   
     
     if(!checkDuplicateSname($uniqueInfos) ){//watch funtion
       $query = "INSERT INTO shop VALUES ($shop_id, '$service', $price, '$name', $dno);";
       
       if($isDevelopment) {
         $result = pg_query($db, $query);
       } else {
         $result = $db->query($query);
       }
       if($result) {
         $msg = "Shop: $name was successfully created.";
       }
     }
   }
     
   return $msg;
}
?>
<?php
function gatherInfo($db, $isDevelopment) {
  $query = "SELECT name FROM shop;";//watch statement
  $data = array();
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $data[] = array('`name' => $row[0]);
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array('name' => $row[0]);
    }
  }
  return $data;
}
?>

<?php
function createID($db, $isDevelopment) {
  $data = array();
  $currentId = 0;
  $query = "SELECT shop_id FROM shop;";//watch statement
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
      if($row["shop_id"] > $currentId) {
        $currentId = $row["shop_id"];
      }
    }
  }
  
  $newEmpId = $currentId + 1;
  return $newEmpId;
}
?>


<?php
function checkDuplicateSname($infos) {
  $result = false;
  foreach($infos as $info) {
    $Game = $info['name'] ?? null;
    if($Game == $_POST["shop_name"]){
	    $result = true;
    } 
  }
	
  return $result;
}
?>
