<?php
include 'app/base.php';
include 'app/indexFunctions.php';
include 'attractOperational.php';
$isDevelopment = true;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  
  $data = getAttractions($dbConn, $isDevelopment);
  $response = setRideInoperable($dbConn, $data, $isDevelopment);
  list($isManager, $dname) = checkIfManager($dbConn, $isDevelopment);
  
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
  $params = array('user' => $user, 'name' => $name, 'attractions' => $attractionNames, 'response' => $response, 'managerMessage' => $mgrMessage, 'managerMenu' => $isManager, 'departmentMsg' => $departmentMsg);
  
  $template = $twig->load('menu.html');
  if($_SESSION['valid']){
    echo $template->render($params);
  } else {
    loginRedirect();
  }
  
?>

<?php
function checkIfManager($db, $isDevelopment) {
  $dno = $_SESSION['dno'];
  $empId = $_SESSION['emp_id'];
  $isManager = false;
  $data = array();
  $query = "SELECT dname,mgr_id FROM department WHERE dnumber=$dno;";
  if($isDevelopment) {
    $results = pg_query($db, $query);
    while($row = pg_fetch_row($results)) {
      $dname = $row[0];
      $mgrID = $row[1];
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $dname = $row["dname"];
      $mgrID = $row["mgr_id"];
    }
  }
  
  if($mgrID == $empId) {
    $isManager = true;
  }
  return array($isManager, $dname);
}
?>