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
  $name = $_SESSION['name'];
  $maintenances = maintenanceReport($dbConn, $isDevelopment);
  
  $template = $twig->load('menu.html');
  $params = array('logout' => $clearSession, 'user' => $user, 'name' => $name, 'maintenances' => $maintenances);
  echo $template->render($params);
?>

<?php
function maintenanceReport($db, $isDevelopment) {
  $data = array();
  if($isDevelopment) {
    $results = pg_query($db ,"select E.name, A.name, M.maintenance_date, M.maintenance_cost, A.operational from public.employee as E, public.attraction as A, public.attraction_maintenance as M where M.e_id=E.employee_id and M.am_id=A.attraction_id;");
    while($row = pg_fetch_row($results)) {
      $empName = $row[0];
      $attractName = $row[1];
      $maintDate = $row[2];
      $cost = $row[3];
      if($row[4] == 't') {
        $isOperational = "Yes";
      } else {
        $isOperational = "No";
      }
      $data[] = array($empName, $attractName, $maintDate, $cost, $isOperational);
    }
  } else {
    $query = "SELECT E.name, A.name, M.maintenance_date, M.maintenance_cost, A.operational FROM employee as E, attraction as A, attraction_maintenance as M WHERE M.e_id=E.employee_id and M.am_id=A.attraction_id;";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      if($row['operational'] == 't') {
        $isOperational = 'Yes';
      } else {
        $isOperational = "No";
      }
      $data[] = array($row["employee.name"], $row["name"], $row["maintenance_date"],$row["maintenance_cost"],  $isOperational);
    }
    $result->closeCursor();
  }  
  return $data;
}
?>