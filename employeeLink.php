<?php
function assign($db, $dno, $empId, $locationId) {
  $empIndentifier = "";
  $table = "";
  $locationIdentifier = "";
  if ($dno == 1) {
    $empIndentifier = "employee_a_id";
    $table = "attraction";
    $locationIdentifier = "attraction_id";
  } elseif ($dno == 2) {
    $empIndentifier = "employee_s_id";
    $table = "shop";
    $locationIdentifier = "shop_id";
  } elseif ($dno == 4) {
    $empIndentifier = "employee_g_id";
    $table = "game";
    $locationIdentifier = "game_id";
  }
  $query = "UPDATE $table SET $empIndentifier = $empId WHERE $locationIdentifier=$locationId;";
  $result = $db->query($query);
   $result->closeCursor();
  return "";
}
?>

<?php
function listEmployees($db, $dno){
  $data = array();
  $query = "SELECT e_name, employee_id FROM employee WHERE dno=$dno;";
  $result = $db->query($query);
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[$row["employee_id"]] = trim($row["e_name"]);
  }
  $result->closeCursor();
  return $data;
}
?>
<?php
function listLocations($db, $dno) {
  $table = "";
  $name = "";
  $id = "";
  $data = array();
  if($dno == 1) {
    $table = "attraction";
    $name = "a_name";
    $id = "attraction_id";
    $empColumn = "employee_a_id";
  } elseif($dno == 2) {
    $table = "shop";
    $name = "name";
    $id = "shop_id";
    $empColumn = "employee_s_id";
  } elseif($dno == 4) {
    $table = "game";
    $name = "gname";
    $id = "game_id";
    $empColumn = "employee_g_id";
  }
  $query = "SELECT $name, $id FROM $table ORDER BY $id ASC;";
  
  $result = $db->query($query);
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array($row[$id], trim($row[$name]));
  }
  $result->closeCursor();
  return $data;
}
?>

<?php
function checkDuplicateEmployees($employees, $locations){
  $msg = "One employee per location.";
  $isDuplicate = true;
  $employeeTracker = array();
  $employeeIds = array();
  if(isset(($_POST["assign"]))){
    foreach($locations as $key => $value) {
      $employeeName = $_POST["employee$key"];
      $employeeTracker[] = $employeeName;
    }
    if(count(array_unique($employeeTracker)) == count($employeeTracker)) {
      $msg = "No duplicate employees found";
      $isDuplicate = false;
      foreach($employeeTracker as $empName) {
        $key = array_search($empName,$employees);
        $employeeIds[] = $key;
      }
    } else {
      $msg = 'Same employees stationed at multiple locations';
    }
  }
  return array($isDuplicate, $msg, $employeeIds);
}
?>

<?php
function listEmployeeNames($employees) {
  $data = array();
  foreach ($employees as $key=>$value){
    $data[] = $value;
  }
  return $data;
}
?>
<?php
function getLocationIds($locations) {
  return $locations[0];
}
?>

<?php
function getLocationNames($locations) {
  return $locations[1];
}
?>
<?php
function assignEmployeeToLocation($db, $dno, $employeeIds, $locationIds) {
  echo "Count: " + count($employeeIds);
  foreach($locationIds as $key=>$location) {
    $id = $employeeIds[$key];
    assign($db, $dno, $id, $location);
  }
}
?>