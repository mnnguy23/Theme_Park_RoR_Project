<?php
function getBrokenAttractions($db) {
  $data = array();
  $dates = array();
  $query = "SELECT DISTINCT M.breakdown_date, M.am_id, A.a_name FROM attraction_maintenance AS M, attraction AS A WHERE M.maintenance_date IS NULL AND A.attraction_id = M.am_id ORDER BY M.breakdown_date DESC;";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $bd_date = $row["breakdown_date"];
      $a_id = $row["am_id"];
      $aName = trim($row['a_name']);
      $dates[] = $bd_date;
      $data[$a_id] = $aName;
  }
  return array($dates,$data);
}
?>

<?php
function setRideFixed($db, $rides) {
  $response = "These rides are inoperable.";
  
  if(isset($_POST["fixed"]) && !empty($_POST["cost"])) {
    
    $cost = $_POST["cost"];
    $empId = $_SESSION['emp_id'];
    $rideName = $_POST["brokenAttraction"];
    $attraction_id = array_search($rideName, $rides);
    echo $attraction_id;
    $query = "UPDATE attraction_maintenance set maintenance_date = CURRENT_DATE, maintenance_cost=$cost, e_id=$empId where am_id = $attraction_id;";
    
    $result = $db->query($query);
    $response = "$rideName has been fixed.";
  }
  return $response;
}
?>