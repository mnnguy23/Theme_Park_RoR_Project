<?php
include 'app/base.php';
include 'app/indexFunctions.php';
$isDevelopment = false;
$twig = loadEnvironment();
$clearSession = developmentMode($isDevelopment);
$dbConn = loadDB($isDevelopment);
?>

<?php
  $rides = displayEmployees($dbConn, $isDevelopment);
  
  $template = $twig->load('displayEmp.html');
  $params = array('logout' => $clearSession, 'user' => $user, 'name' => $name);
  echo $template->render($params);
?>

<?php
function displayEmployees($db, $isDevelopment) {
  $data = array();
  if($isDevelopment) {
    $results = pg_query($db ,"SELECT name, employee_id, bdate, address, phone_number, salary, dno  FROM public.attraction");
    while($row = pg_fetch_row($results)) {
      $data[] = array($row["name"], $row["employee_id"], $row["bdate"], row["address"], row["phone_number"], row["salary"], row["dno"]);
    }
  } else {
    $query = "SELECT name, employee_id, bdate, address, phone_number, salary, dno"
         . " FROM employee";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["name"], $row["employee_id"], $row["bdate"], row["address"], row["phone_number"], row["salary"], row["dno"]);
    }
    $result->closeCursor();
  }
  return $data;
}
?>
