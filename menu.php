<?php
include 'app/base.php';
include 'app/indexFunctions.php';
$isDevelopment = true;
$twig = loadEnvironment();
$clearSession = developmentMode($isDevelopment);
$dbConn = loadDB($isDevelopment);
?>

<?php
  $user = $_SESSION['user'];
  $name = $_SESSION['name'];
  $rides = maintenanceReport($dbConn, $isDevelopment);
  
  $template = $twig->load('menu.html');
  $params = array('logout' => $clearSession, 'user' => $user, 'name' => $name, 'rides' => $rides);
  echo $template->render($params);
?>

<?php
function maintenanceReport($db, $isDevelopment) {
  $data = array();
  if($isDevelopment) {
    $results = pg_query($db ,"SELECT attraction_id, name, maintenance_date, operational  FROM public.attraction");
    while($row = pg_fetch_row($results)) {
      $id = $row[0];
      $name = $row[1];
      $maintDate = $row[2];
      if($row[3] == 't') {
        $isOperational = 'Yes';
      } else {
        $isOperational = "No";
      }
      $data[] = array($id, $name, $maintDate, $isOperational);
    }
  } else {
    $query = "SELECT attraction_id, name, maintenance_date, operational"
         . " FROM ride";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      if($row['operational'] == 't') {
        $isOperational = 'Yes';
      } else {
        $isOperational = "No";
      }
      $data[] = array($row["ride_id"], $row["name"], $row["maintenance_date"], $isOperational);
    }
    $result->closeCursor();
  }  
  return $data;
}
?>