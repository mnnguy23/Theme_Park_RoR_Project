<?php
include 'app/base.php';
include 'employeeLink.php';
$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  $dno = $_SESSION['dno'];
  $department = "";
  if($dno == 1) {
    $department = "Attraction";
    $valueType = "people";
  } elseif($dno == 2) {
    $department = "Sales";
    $valueType = "sales";
  } elseif($dno == 4) {
    $department = "Game";
    $valueType = "people";
  }
  if($dno == 2) {
    $merchandises = getMerchandises($dbConn);
    $product = array_map("getMerchNames", $merchandises);
    $logAlert = "Enter how much each merchandise was sold";
  } else {
    $locations = listLocations($dbConn, $dno);
    $product = array_map("getLocationNames", $locations);
    $logAlert = "Enter the amount of $valueType for each location";
  }
  if(isset($_POST["create"])){
    $productValues = retrieveValuesForLocation($dbConn, $product);
    $logAlert = createLog($dbConn, $dno, $productValues);
  }
  
  $params = array('locationsNames' => $product, 'department'=> $department, 'logAlert'=> $logAlert);
  $template = $twig->load("logInput.html");
  if($_SESSION["valid"]) {
    echo $template->render($params);
  } else {
    loginRedirect();
  }
?>

<?php
function createLog($db, $dno, $data){
  $table = "";
  if($dno == 1) {
    $table = "attraction_attendance";
  } elseif($dno == 2) {
    $table = "merchandise_sales";
  } elseif($dno == 4) {
    $table = "game_sales";
  }
  $postgresArray = phpToPostGresArray($data);
  $query = "INSERT into $table VALUES(CURRENT_DATE, $postgresArray)";
  $result = $db->query($query);
  $result->closeCursor();
  date_default_timezone_set('US/Central');
  $currentDate = date('Y-m-d');
  return "Succesfully created a log  for $currentDate";
}
?>

<?php
function retrieveValuesForLocation($db, $locations) {
  $data = array();
    foreach($locations as $key=>$location) {
      $id = "location$key";
      $data[] = $_POST[$id];
    }
    echo count($data);
  return $data;
}
?>

<?php
function phpToPostGresArray($phpArray) {
  return "'{".join(",",$phpArray)."}'";
}
?>