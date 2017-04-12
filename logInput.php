<?php
include 'app/base.php';
include 'employeeLink.php';
$isDevelopment = true;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  $dno = $_SESSION['dno'];
  $locations = listLocations($dbConn, $dno);
  $locNames = array_map("getLocationNames", $locations);
  $params = array('locationsNames' => $locNames);
  $template = $twig->load("logInput.html");
  if($_SESSION["valid"]) {
    echo $template->render($params);
  } else {
    loginRedirect();
  }
?>
  

<?php
function createLog($db, $dno){}
?>