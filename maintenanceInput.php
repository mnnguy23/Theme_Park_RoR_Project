<?php
function getBrokenAttractions($db) {
  $data = array();
  $query = "SELECT DISTINCT breakdown_date, am_id FROM attraction_maintenance WHERE maintenance_date IS NULL;";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $bd_date = $row["breakdown_date"];
      $a_id = $row["am_id"];
      $data[] = array($bd_date, $a_id);
  }
  return $data;
}
?>

<?php
function getRideNames($db) {
  $data = array();
  $query = "SELECT DISTINCT A.name, A.attraction_id FROM attraction AS A, attraction_maintenance AS AM WHERE A.attraction_id=AM.am_id AND AM.maintenance_date IS NULL;";
  $result = $db->query($query);
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $aName = trim($row["name"]);
    $aId = $row["attraction_id"];
    $data[$aId] = $aName;
  }
  $result->closeCursor();
  return $data;
}
?>

<?php
function setRideFixed($db, $rides) {
  $response = "These rides are inoperable.";
  
  if(isset($_POST["fixed"]) && !empty($_POST["cost"])) {
    
    $cost = $_POST["cost"];
    $empId = $_SESSION['emp_id'];
    $rideName = $_POST["brokenAttraction"];
    $attraction_id = '';
    foreach($rides as $key => $value) {
      if(strcmp($rideName, $value) == 0 ) {
        $attraction_id = $key;
        $response = "this ride: $rideName is now set to operational.";
      }
    }
    $query = "UPDATE attraction_maintenance set maintenance_date = CURRENT_DATE, maintenance_cost=$cost, e_id=$empId where am_id = $attraction_id;";
    
    $result = $db->query($query);
  }
  return $response;
}
?>