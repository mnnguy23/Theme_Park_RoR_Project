<?php
include 'app/base.php';
include 'app/indexFunctions.php';
include 'attractOperational.php';
include 'maintenanceInput.php';
$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  
  $data = getAttractions($dbConn);
  $response = setRideInoperable($dbConn, $data);
  list($isManager, $dname) = checkIfManager($dbConn);
  
  
  // for the maintenance Input
  $brokenRides = getBrokenAttractions($dbConn);
  $rideNames = getRideNames($dbConn);
  $brokenList = array();
  
  if(count($brokenRides) > 0) {
    foreach($brokenRides as $ride) {
      $aName = $rideNames[$ride[1]] ?? null;
      $brokenList[] = array($aName, $ride[0]);      
    } 
  }
  $maintResponse = setRideFixed($dbConn, $rideNames);
  // end of maintenance input
  
  if($isManager) {
    $mgrMessage = "You are the manager of: $dname";
  } else {
    $mgrMessage = "You are not a manager";
  }
  
  $departmentMsg = "You are part of $dname";
  
  $attractionNames = array();
  foreach($data as $key => $value) {
    $attractionNames[] = $value;
  }
  $params = array('user' => $user, 'name' => $name, 'attractions' => $attractionNames, 'response' => $response, 'managerMessage' => $mgrMessage, 'managerMenu' => $isManager, 'departmentMsg' => $departmentMsg, 'brokeRides' => $brokenList, 'maintenanceResponse' => $maintResponse);
  
  $template = $twig->load('menu.html');
  if($_SESSION['valid']){
    echo $template->render($params);
  } else {
    loginRedirect();
  }
  
?>

<?php
function checkIfManager($db) {
  $dno = $_SESSION['dno'];
  $empId = $_SESSION['emp_id'];
  $isManager = false;
  $data = array();
  $query = "SELECT dname,mgr_id FROM department WHERE dnumber=$dno;";
  
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $dname = $row["dname"];
      $mgrID = $row["mgr_id"];
    }
  if($mgrID == $empId) {
    $isManager = true;
  }
  return array($isManager, $dname);
}
?>