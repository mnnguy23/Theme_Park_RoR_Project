<?php
include 'app/base.php';
include 'maintenanceReport.php';
include 'employeeLink.php';
include 'dailyReport.php';

$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('report.html');
$dno = $_SESSION['dno'];

$reports = '';
$selectReport = '';



if (isset($_POST['submit']) and $dno == 3) {
  // Maintenance Department //
  $selectReport = $_POST['report'];
  if($_POST['report'] == "Fixed") {
    $query = inputDateQuery($isDevelopment);
    $reports = maintenanceReport($dbConn, $query);
  } elseif ($_POST['report'] == "Ongoing") {
    $reports = ongoingReport($dbConn);
  }
  // End of Maintenance //
} else {
  // All the the department //
  $locations = listLocations($dbConn, $dno);
  $locNames = array_map('getLocationNames', $locations);
  $logs = queryReport($dbConn, $dno);
  $dateLogs = array_map('getTimeLogs', $logs);
  $amountLogs = array_map('getAmountLogs', $logs);
  // End of the rest //
}

$params = array('reports' => $reports, 'selectedReport'=>$selectReport, 'dno'=> $dno, 'locations' => $locNames, 'dates' => $dateLogs, 'amountLogs' => $amountLogs);
if($_SESSION['valid']){
  echo $template->render($params);
} else {
  loginRedirect();
}
?>

