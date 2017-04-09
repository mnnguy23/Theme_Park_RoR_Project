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
echo $template->render(array('msg' => $msg));
?>

<?php
function inputEmployee($db, $isDevelopment) {
  $uniqueInfos = gatherInfo($db, $isDevelopment);
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["name"];
     
     if(!checkDuplicateAname($uniqueInfos)) {
       $ssn = $_POST["attraction_name"];
     } else {
       $msg = "Duplicate Attraction name found";
     }

     
     $att_id = createAttractionID($db, $isDevelopment);
	 $name = $_POST["attraction_name"];
     $price = $_POST["price"];
     $capacity = $_POST["capacity"];
     $date_built = $_POST["date_built"];
     $m_date = $_POST["m_date"];
     $dno = $_SESSION['dno'];
     $op_cost=$_SESSION['op_cost'];
	 $operational=true;
     
     if(!checkDuplicateAname($uniqueInfos) ){
       $query = "INSERT INTO employee VALUES ($att_id, $price,$capacity '$date_built', '$m_date;, '$name', $dno, $op_cost, $operational);";
       
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
  $query = "SELECT name, attraction_id FROM attraction;";
  $data = array();
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $data[] = array('name' => $row[0]);
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
    $Attraction = $info['name'] ?? null;
    if($Attraction == $_POST["attraction_name"]){
      $result = true;
    } 
  }
  return $result;
}
?>



