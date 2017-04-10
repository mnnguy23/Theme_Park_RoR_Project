<?php
include 'app/base.php';
include 'app/indexFunctions.php';
$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>


<?php

$template = $twig->load('maintenanceReport.html');
$query = inputDateQuery($isDevelopment);

$reports = maintenanceReport($dbConn, $isDevelopment, $query);
$params = array('reports' => $reports);

if($_SESSION['valid']){
  echo $template->render($params);
} else {
  loginRedirect();
}
?>

<?php
function maintenanceReport($db, $isDevelopment, $query) {
  $data = array();
  if($isDevelopment) {
    $results = pg_query($db ,$query);
    while($row = pg_fetch_row($results)) {
      $empName = $row[0];
      $attractName = $row[1];
      $maintDate = $row[2];
      $cost = $row[3];
      $data[] = array($empName, $attractName, $maintDate, $cost);
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["e_name"], $row["name"], $row["maintenance_date"],$row["maintenance_cost"],  $isOperational);
    }
    $result->closeCursor();
  } 
  return $data;
}
?>


<?php
function inputDateQuery() {
  $query = "SELECT E.e_name, A.a_name, M.maintenance_date, M.maintenance_cost FROM employee AS E, attraction AS A, attraction_maintenance AS M WHERE M.e_id=E.employee_id AND M.am_id=A.attraction_id;";

  if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
  
    if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
      $startDate = $_POST["startDatepicker"];
      $endDate = $_POST["endDatepicker"];
      $query = "SELECT E.e_name, A.a_name, M.maintenance_date, M.maintenance_cost FROM employee AS E, attraction AS A, attraction_maintenance AS M WHERE M.e_id=E.employee_id AND M.am_id=A.attraction_id AND M.maintenance_date between '$startDate' AND '$endDate';";
    }
  }
  return $query;
}
?>