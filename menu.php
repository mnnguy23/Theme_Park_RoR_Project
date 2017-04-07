<?php
include 'app/base.php';
include 'app/indexFunctions.php';
include 'attractOperational.php';
$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  $data = getAttractions($dbConn, $isDevelopment);
  $response = setRideInoperable($dbConn, $data, $isDevelopment);
  $attractionNames = array();
  foreach($data as $key => $value) {
    $attractionNames[] = $value;
  }
  echo count($attractionNames);
  $params = array('user' => $user, 'name' => $name, 'attractions' => $attractionNames, 'response' => $response);
  
  $template = $twig->load('menu.html');
  if($_SESSION['valid']){
    echo $template->render($params);
  } else {
    loginRedirect();
  }
  
?>