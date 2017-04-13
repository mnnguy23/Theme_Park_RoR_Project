<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('addAttraction.html');
$msg = inputEmployee($dbConn, $isDevelopment);
echo $template->render(array('msg' => $msg, 'dno' => $_SESSION['dno']));
?>

<?php
function inputEmployee($db, $isDevelopment) {
  $uniqueInfos = gatherInfo($db, $isDevelopment);
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["attraction_name"];
     
     if(!checkDuplicateAname($uniqueInfos)) {
       $name = $_POST["attraction_name"];
	//$msg="Name Approved";     
     } else {
       $msg = "Duplicate Attraction name found";
     }

     
     $att_id = createAttractionID($db, $isDevelopment);
     $price = $_POST["price"];
     $capacity = $_POST["capacity"];
     $date_built = $_POST["date_built"];
     $m_date = $_POST["m_date"];;
     //all inputs have been tested for correctnes with $msg	   
     
     if(!checkDuplicateAname($uniqueInfos) ){
       $query = "INSERT INTO attraction VALUES ($att_id, $price, $capacity, '$date_built', '$m_date', '$name',  TRUE);";
       
       if($isDevelopment) {
         $result = pg_query($db, $query);
       } else {
         $result = $db->query($query);
       }
       if($result) {
         $msg = "Attraction: $name was successfully created.";
       }
     }
   }
     
   return $msg;
}
?>
<?php
function gatherInfo($db, $isDevelopment) {
  $query = "SELECT a_name FROM attraction;";
  $data = array();
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $data[] = array('a_name' => $row[0]);
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array('a_name' => $row[0]);
    }
  }
  return $data;
}
?>

<?php
function createAttractionID($db, $isDevelopment) {
  $data = array();
  $currentId = 0;
  $query = "SELECT attraction_id FROM attraction;";
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
      if($row["attraction_id"] > $currentId) {
        $currentId = $row["attraction_id"];
      }
    }
  }
  
  $newEmpId = $currentId + 1;
  return $newEmpId;
}
?>


<?php
function checkDuplicateAname($infos) {
  $result = false;
  foreach($infos as $info) {
    $Attraction = $info['a_name'] ?? null;
    if($Attraction == $_POST["attraction_name"]){
      $result = true;
    } 
  }
  return $result;
}
?>



