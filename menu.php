<?php
include 'app/base.php';
include 'app/indexFunctions.php';
$isDevelopment = false;
$twig = loadEnvironment();
$clearSession = developmentMode($isDevelopment);
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $rides = maintenanceReport($dbConn, $isDevelopment);
  
  $template = $twig->load('menu.html');
  $params = array('logout' => $clearSession, 'user' => $user, 'fname' => $fname, 'lname' => $lname, 'rides' => $rides);
  echo $template->render($params);
?>

<?php
function maintenanceReport($db, $isDevelopment) {
  $data = array();
  if($isDevelopment) {
    $results = pg_query($db ,"SELECT ride_id, name, maintenance_date  FROM public.ride");
    while($row = pg_fetch_row($results)) {
      $id = $row[0];
      $name = $row[1];
      $maintDate = $row[2];
      $data[] = array($id, $name, $maintDate);
    }
  } else {
    $query = "SELECT ride_id, name, maintenance_date,"
         . " FROM ride";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["ride_id"], $row["name"], $row["maintenance_date"]);
    }
    $result->closeCursor();
  }  
  return $data;
}
?>