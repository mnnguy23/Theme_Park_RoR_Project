<?php
include 'app/base.php';
include 'app/indexFunctions.php';
include 'dropEmployee.php';
$isDevelopment = false;
$twig = loadEnvironment();
$dbConn = loadDB($isDevelopment);
?>

<?php
  $dno = $_SESSION['dno'];
  $displayEmps = displayEmployees($dbConn,$dno);
  $template = $twig->load('displayEmp.html');
  
  // Deleting Employees
  $deletEmps = getEmployees($dbConn,$dno);
  $msg = deleteEmployee($dbConn,$dno, $deletEmps);
  // End of Deletion
  
  $params = array('employees' => $displayEmps, 'dno'=>$dno, 'deleteEmps'=>$deletEmps, 'msg'=>$msg);
  
  if($_SESSION['valid']){
    echo $template->render($params);
  } else {
    loginRedirect();
  }
?>

<?php
function displayEmployees($db,$dno) {
  $data = array();
    $query = "SELECT e_name, employee_id, bdate, address, phone_number, salary, dno"
         . " FROM employee WHERE $dno=dno";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["e_name"], $row["employee_id"], $row["bdate"], $row["address"], $row["phone_number"], $row["salary"], $row["dno"]);
    }
    $result->closeCursor();
  return $data;
}
?>
