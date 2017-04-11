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

$reports = '';
$selectReport = '';
if (isset($_POST['select'])) {
  $selectReport = $_POST['report'];
  if($_POST['report'] == "Fixed") {
    $reports = maintenanceReport($dbConn, $query);
  } elseif ($_POST['report'] == "Ongoing") {
    $reports = ongoingReport($dbConn);
  }
}
$params = array('reports' => $reports, 'selectedReport'=>$selectReport);

if($_SESSION['valid']){
  echo $template->render($params);
} else {
  loginRedirect();
}
?>

<?php
function maintenanceReport($db, $query) {
  $data = array();
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["e_name"], $row["a_name"], $row["maintenance_date"],$row["maintenance_cost"]);
    }
    $result->closeCursor();
  return $data;
}
?>


<?php
function inputDateQuery() {
  $query = "SELECT E.e_name, A.a_name, M.maintenance_date, M.maintenance_cost FROM employee AS E, attraction AS A, attraction_maintenance AS M WHERE M.maintenance_date IS NOT NULL AND E.employee_id=M.e_id AND M.am_id=A.attraction_id;";

  if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
  
    if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
      $startDate = $_POST["startDatepicker"];
      $endDate = $_POST["endDatepicker"];
      $query = "SELECT E.e_name, A.a_name, M.maintenance_date, M.maintenance_cost FROM employee AS E, attraction AS A, attraction_maintenance AS M WHERE M.am_id=A.attraction_id AND M.breakdown_date between '$startDate' AND '$endDate';";
    }
  }
  return $query;
}
?>

<?php
function ongoingReport($db) {
  $data = array();
  $query = "SELECT A.a_name,M.breakdown_date, M.am_id FROM attraction AS A, (SELECT DISTINCT breakdown_date, am_id FROM attraction_maintenance where maintenance_date is null) AS M WHERE M.am_id=A.attraction_id;";
  $result = $db->query($query);
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array($row['a_name'], $row['breakdown_date']);
  }
  return $data;
}
?>