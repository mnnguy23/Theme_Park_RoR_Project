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
$department = $_SESSION["department"];

$reports = '';
$selectReport = '';
$productNames = '';
$dateLogs = '';
$amountLogs = '';
$sumLogs = "";
$averageLogs ="";

if(isset($_POST['submit'])){
  if ($dno == 3) {
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
    if($dno == 2) {
      // Sales Department
      $merchandises = getMerchandises($dbConn);
      $productNames = array_map('getMerchNames', $merchandises);
      // End of Sales //
    } else {
      // Rest of the department //
      $locations = listLocations($dbConn, $dno);
      $productNames = array_map('getLocationNames', $locations);
      // End of the rest //
    }
   
    $logs = queryReport($dbConn, $dno);
    $dateLogs = array_map('getTimeLogs', $logs);
    $amountLogs = array_map('getAmountLogs', $logs);
    $averageLogs = array_map('getAverageLogs', $logs);
    $sumLogs = array_map('getSumLogs', $logs);
  }
}


$params = array('reports' => $reports, 'selectedReport'=>$selectReport, 'dno'=> $dno, 'locations' => $productNames, 'dates' => $dateLogs, 'amountLogs' => $amountLogs, 'averageLogs' => $averageLogs, 'sumLogs'=>$sumLogs, "department" => $department);
if($_SESSION['valid']){
  echo $template->render($params);
} else {
  loginRedirect();
}
?>

