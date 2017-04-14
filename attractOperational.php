
<?php
function getAttractions($db) {
  $data = array();
    $query = "SELECT attraction_id, a_name FROM attraction WHERE operational= true;";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $attract_id = $row['attraction_id'];
      $name = trim($row['a_name']);
      $data[$attract_id] = $name;
    }
    $result->closeCursor();
  return $data;
}
?>

<?php
function setRideInoperable($db, $rides) {
  $response = "Set a ride inoperable.";
  if(isset($_POST['notOperational']) && !empty($_POST["attractionName"])) {
    if(isset($_POST['checkBox'])){
      $rideName = $_POST["attractionName"];
      $attraction_id = '';
    
      foreach($rides as $key => $value) {
        if(strcmp($rideName, $value) == 0 ) {
          $attraction_id = $key;
        }
      }
    
        $currentTime = (new \DateTime())->format('Y-m-d H:i:s');
        $query = "UPDATE attraction SET operational = FALSE WHERE attraction_id = $attraction_id;";
          $result = $db->query($query);
          if($result) {
            $response = "this ride: $rideName is now set to not operational.";
          }
          $result->closeCursor();
    } else {
      $response = "Check the box to confirm the ride.";
    }
  }
  return $response;
}
?>